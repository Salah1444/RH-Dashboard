<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employer extends Model
{

    protected $table      = 'Employer';
    protected $primaryKey = 'id_emp';

    protected $fillable = [
        'COD_AG', 'CIN_A', 'CIN_N', 'CIN',
        'NOM_PRENOM_FR', 'NOM_PRENOM_AR',
        'photo', 'DATE_NAISS', 'LIEU_NAIS', 'SEXE', 'CODE_NAT',
        'ADRESSE_FR', 'ADRESSE_AR', 'VILLE',
        'TEL_FIXE', 'TEL_PORTABLE', 'ADRESSE_ELEC',
        'SIT_F_AG', 'Sit_Familiale', 'RIB', 'NUM_PB',
        'CD_DIPP', 'LL_DIPP', 'CD_DIPS', 'LL_DIPS', 'DT_DIPPROF', 'DT_DIPSCOL',
        'ville_id', 'position_id',
    ];

    protected $casts = [
        'DATE_NAISS' => 'date',
        'DT_DIPPROF' => 'date',
        'DT_DIPSCOL' => 'date',
    ];

    // ── Relations ──────────────────────────────────────────────────

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'ville_id', 'id_commune');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'id_position');
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class, 'emp_id', 'id_emp');
    }

    public function affectationActuelle(): HasOne
    {
        return $this->hasOne(Affectation::class, 'emp_id', 'id_emp')
                    ->latestOfMany('DATE_DEBUT_AFF')
                    ->with(['etablissement.commune.province.region', 'fonction']);
    }

    public function cadreHistory(): HasMany
    {
        return $this->hasMany(EmployeCadreHistory::class, 'emp_id', 'id_emp');
    }

    public function cadreActuel(): HasOne
    {
        return $this->hasOne(EmployeCadreHistory::class, 'emp_id', 'id_emp')
                    ->latestOfMany('DT_AFF_Cadr')
                    ->with('cadre');
    }

    public function gradeHistory(): HasMany
    {
        return $this->hasMany(EmployeGradeHistory::class, 'emp_id', 'id_emp');
    }

    public function gradeActuel(): HasOne
    {
        return $this->hasOne(EmployeGradeHistory::class, 'emp_id', 'id_emp')
                    ->latestOfMany('DAT_EFF_GR')
                    ->with('grade');
    }

    public function echelonHistory(): HasMany
    {
        return $this->hasMany(EmployeEchelonHistory::class, 'emp_id', 'id_emp');
    }

    public function echelonActuel(): HasOne
    {
        return $this->hasOne(EmployeEchelonHistory::class, 'emp_id', 'id_emp')
                    ->latestOfMany('DAT_EFF_ELO')
                    ->with('echelon');
    }

    public function situationStatutaireHistory(): HasMany
    {
        return $this->hasMany(EmployeSituationStatutaireHistory::class, 'emp_id', 'id_emp');
    }

    public function situationStatutaireActuelle(): HasOne
    {
        return $this->hasOne(EmployeSituationStatutaireHistory::class, 'emp_id', 'id_emp')
                    ->latestOfMany('DATE_SIT_STAT')
                    ->with('situationStatutaire');
    }

    public function conjoints(): HasMany
    {
        return $this->hasMany(Conjoint::class, 'emp_id', 'id_emp');
    }

    public function enfants(): HasMany
    {
        return $this->hasMany(Enfant::class, 'emp_id', 'id_emp')->with('garde');
    }

    public function diplomes(): HasMany
    {
        return $this->hasMany(Diplome::class, 'emp_id', 'id_emp');
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class, 'emp_id', 'id_emp')->with('congee');
    }

    // ── Accessors ──────────────────────────────────────────────────

    public function getAgeAttribute(): ?int
    {
        return $this->DATE_NAISS?->age;
    }

    // ── Scopes ─────────────────────────────────────────────────────

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        if (!$term) return $q;
        return $q->where(function ($q) use ($term) {
            $q->where('NOM_PRENOM_FR', 'like', "%{$term}%")
              ->orWhere('NOM_PRENOM_AR',  'like', "%{$term}%")
              ->orWhere('CIN',            'like', "%{$term}%")
              ->orWhere('COD_AG',         'like', "%{$term}%");
        });
    }

    public function scopeFilterSexe(Builder $q, ?string $v): Builder
    {
        return $v ? $q->where('SEXE', $v) : $q;
    }

    public function scopeFilterSitFamiliale(Builder $q, ?string $v): Builder
    {
        return $v ? $q->where('Sit_Familiale', $v) : $q;
    }

    public function scopeFilterRegion(Builder $q, ?string $v): Builder
    {
        if (!$v) return $q;
        return $q->whereHas('affectationActuelle.etablissement.commune.province.region',
            fn($r) => $r->where('LIB_REGION_FR', $v)
        );
    }

    public function scopeFilterCadre(Builder $q, ?string $v): Builder
    {
        if (!$v) return $q;
        return $q->whereHas('cadreActuel.cadre',
            fn($c) => $c->where('Lib_Cadre_FR', $v)
        );
    }
}





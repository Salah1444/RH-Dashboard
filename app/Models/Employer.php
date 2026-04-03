<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employer extends Model
{

    protected $table      = 'employer';
    protected $primaryKey = 'COD_AG';

    protected $fillable = [
        'CIN_A', 'CIN_N', 'CIN',
        'NOM_PRENOM_FR', 'NOM_PRENOM_AR',
        'photo', 'DATE_NAISS', 'LIEU_NAISS', 'SEXE', 'CODE_NAT',
        'ADRESSE_FR', 'ADRESSE_AR',
        'TEL_FIXE', 'TEL_PORTABLE', 'ADRESSE_ELEC',
        'Sit_Familiale', 'RIB', 'NUM_PB',
        'ville_id', 'position_id',
    ];

    protected $casts = [
        'DATE_NAISS' => 'date',
    ];

    // ── Relations ──────────────────────────────────────────────────

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'ville_id', 'CD_COM');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'COD_POS');
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class, 'code_agent', 'COD_AG');
    }

    public function affectationActuelle(): HasOne
    {
        return $this->hasOne(Affectation::class, 'code_agent', 'COD_AG')
                    ->latestOfMany('DATE_DEBUT_AFF')
                    ->with(['etablissement.commune.province.region', 'fonction']);
    }

    public function cadreHistory(): HasMany
    {
        return $this->hasMany(EmployeCadreHistory::class, 'code_agent', 'COD_AG');
    }

    public function cadreActuel(): HasOne
    {
        return $this->hasOne(EmployeCadreHistory::class, 'code_agent', 'COD_AG')
                    ->latestOfMany('DT_AFF_Cadre')
                    ->with('cadre');
    }

    public function gradeHistory(): HasMany
    {
        return $this->hasMany(EmployeGradeHistory::class, 'code_agent', 'COD_AG');
    }

    public function gradeActuel(): HasOne
    {
        return $this->hasOne(EmployeGradeHistory::class, 'code_agent', 'COD_AG')
                    ->latestOfMany('DAT_EFF_GR')
                    ->with('grade');
    }

    public function echelonHistory(): HasMany
    {
        return $this->hasMany(EmployeEchelonHistory::class, 'code_agent', 'COD_AG');
    }

    public function echelonActuel(): HasOne
    {
        return $this->hasOne(EmployeEchelonHistory::class, 'code_agent', 'COD_AG')
                    ->latestOfMany('DAT_EFF_ELO')
                    ->with('echelon');
    }

    public function situationStatutaireHistory(): HasMany
    {
        return $this->hasMany(EmployeSituationStatutaireHistory::class, 'code_agent', 'COD_AG');
    }

    public function situationStatutaireActuelle(): HasOne
    {
        return $this->hasOne(EmployeSituationStatutaireHistory::class, 'code_agent', 'COD_AG')
                    ->latestOfMany('DATE_SIT_STAT')
                    ->with('situationStatutaire');
    }

    public function conjoints(): HasMany
    {
        return $this->hasMany(Conjoint::class, 'code_agent', 'COD_AG');
    }

    public function enfants(): HasMany
    {
        return $this->hasMany(Enfant::class, 'code_agent', 'COD_AG')->with('garde');
    }

    public function diplomes(): HasMany
    {
        return $this->hasMany(Diplome::class, 'code_agent', 'COD_AG');
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class, 'code_agent', 'COD_AG')->with('congee');
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
              ->orWhere('like', "%{$term}%");
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





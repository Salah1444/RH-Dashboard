<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model {
    protected $table = 'employer';
    protected $primaryKey = 'COD_AG';
    protected $fillable = [
        'CIN_A', 'CIN_N', 'CIN', 'NOM_PRENOM_FR', 'NOM_PRENOM_AR', 'photo',
        'DATE_NAISS', 'LIEU_NAISS', 'SEXE', 'CODE_NAT',
        'ADRESSE_FR', 'ADRESSE_AR', 'TEL_FIXE', 'TEL_PORTABLE',
        'ADRESSE_ELEC', 'Sit_Familiale', 'RIB', 'NUM_PB',
        'ville_id', 'position_id',
    ];

    public function commune()     { return $this->belongsTo(Commune::class,  'ville_id',    'CD_COM'); }
    public function position()    { return $this->belongsTo(Position::class, 'position_id', 'COD_POS'); }
    public function affectations(){ return $this->hasMany(Affectation::class, 'code_agent', 'COD_AG'); }

    public function cadreHistories()    { return $this->hasMany(EmployeCadreHistory::class,                 'code_agent', 'COD_AG'); }
    public function gradeHistories()    { return $this->hasMany(EmployeGradesHistory::class,                'code_agent', 'COD_AG'); }
    public function echelonHistories()  { return $this->hasMany(EmployeEchelonHistory::class,               'code_agent', 'COD_AG'); }
    public function situationStatutaireHistories() {
        return $this->hasMany(EmployeSituationStatutaireHistory::class, 'code_agent', 'COD_AG');
    }

    public function conjoints() { return $this->hasMany(Conjoint::class, 'code_agent', 'COD_AG'); }
    public function enfants()   { return $this->hasMany(Enfant::class,   'code_agent', 'COD_AG'); }
    public function diplomes()  { return $this->hasMany(Diplome::class,  'code_agent', 'COD_AG'); }
    public function absences()  { return $this->hasMany(Absence::class,  'code_agent', 'COD_AG'); }

    /** Accessor : deux premières lettres du nom complet */
    public function getInitialesAttribute(): string
    {
        $parts = explode(' ', $this->NOM_PRENOM_FR ?? '');
        return strtoupper(substr($parts[0] ?? '?', 0, 1) . substr($parts[1] ?? '', 0, 1));
    }
}

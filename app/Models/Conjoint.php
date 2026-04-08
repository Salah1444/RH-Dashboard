<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Conjoint extends Model {
    protected $table = 'conjoints';
    protected $primaryKey = 'id_conj';
    protected $fillable = [
        'code_agent', 'DATE_SIT_FAM', 'nom_prenom_conjoint',
        'rang_conj', 'cin_conj', 'doti_conj', 'nationalite_conj', 'fonction_conj',
    ];
    public function employer() { return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG'); }
}

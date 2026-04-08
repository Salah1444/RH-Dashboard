<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SituationStatutaire extends Model {
    protected $table = 'situation_statutaire';
    protected $primaryKey = 'sit_st_id';
    protected $fillable = [
        'CODE_SIT_STATUTAIRE',
        'LIB_SITUATION_STATUTAIRE_FR',
        'LIB_SITUATION_STATUTAIRE_AR',
    ];
    public function histories() {
        return $this->hasMany(EmployeSituationStatutaireHistory::class, 'sit_st_id', 'sit_st_id');
    }
}

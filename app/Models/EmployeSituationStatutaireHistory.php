<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmployeSituationStatutaireHistory extends Model {
    protected $table = 'employe_situation_statutaire_history';
    protected $fillable = ['code_agent', 'sit_st_id', 'DATE_SIT_STAT', 'DATE_PREV_RETRAITE'];
    protected $casts = [
        'DATE_SIT_STAT'        => 'date',
        'DATE_PREV_RETRAITE'   => 'date',
    ];
    
    public function employer()            { return $this->belongsTo(Employer::class,          'code_agent', 'COD_AG'); }
    public function situationStatutaire() { return $this->belongsTo(SituationStatutaire::class, 'sit_st_id', 'sit_st_id'); }
}

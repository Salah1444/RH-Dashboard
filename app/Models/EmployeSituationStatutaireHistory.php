<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeSituationStatutaireHistory extends Model
{
    protected $table = 'employe_situation_statutaire_history';

    protected $fillable = [
        'emp_id', 'isit_st_id',
        'DATE_SIT_STAT', 'DATE_PREV_RETRAITE',
    ];

    protected $casts = [
        'DATE_SIT_STAT'       => 'date',
        'DATE_PREV_RETRAITE'  => 'date',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'emp_id', 'id_emp');
    }

    public function situationStatutaire(): BelongsTo
    {
        return $this->belongsTo(SituationStatutaire::class, 'isit_st_id', 'isit_st_id');
    }
}

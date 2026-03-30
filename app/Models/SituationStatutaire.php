<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SituationStatutaire extends Model
{
    protected $table      = 'situation_statutaire';
    protected $primaryKey = 'isit_st_id';

    protected $fillable = [
        'CODE_SIT_STATUTAIRE',
        'LIB_SITUATION_STATUTAIRE_FR',
        'LIB_SITUATION_STATUTAIRE_AR',
    ];

    public function history(): HasMany
    {
        return $this->hasMany(EmployeSituationStatutaireHistory::class, 'isit_st_id', 'isit_st_id');
    }
}

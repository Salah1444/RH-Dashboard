<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cadre extends Model
{
    protected $table      = 'cadre';
    protected $primaryKey = 'id_cadre';

    protected $fillable = ['CADRE', 'Lib_cadre_AR', 'Lib_Cadre_FR'];

    public function history(): HasMany
    {
        return $this->hasMany(EmployeCadreHistory::class, 'id_cadre', 'id_cadre');
    }
}

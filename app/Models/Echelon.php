<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Echelon extends Model
{
    protected $table      = 'echelon';
    protected $primaryKey = 'id_ech';

    protected $fillable = ['COD_ECH', 'COD_ELO'];

    public function history(): HasMany
    {
        return $this->hasMany(EmployeEchelonHistory::class, 'id_ech', 'id_ech');
    }
}

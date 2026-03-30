<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $table      = 'region';
    protected $primaryKey = 'id_region';

    protected $fillable = ['CD_REG', 'LIB_REGION_FR', 'LIB_REGION_AR'];

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class, 'id_region', 'id_region');
    }

    public function modiriyas(): HasMany
    {
        return $this->hasMany(Modiriya::class, 'id_region', 'id_region');
    }
}

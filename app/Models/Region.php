<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $table      = 'region';
        protected $primaryKey = 'CD_REG';

    protected $fillable = ['LIB_REGION_FR', 'LIB_REGION_AR'];

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class, 'CD_REG', 'CD_REG');
    }

    public function modiriyas(): HasMany
    {
        return $this->hasMany(Modiriya::class, 'id_region', 'CD_REG');
    }
}

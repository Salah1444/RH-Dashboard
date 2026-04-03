<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    protected $table      = 'commune';
        protected $primaryKey = 'CD_COM';

    protected $fillable = [
        'LIB_COMMUNE_FR', 'LIB_COMMUNE_AR',
        'LIB_MILIEU_FR', 'LIB_MILIEU_AR', 'CD_PRV',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'CD_PRV', 'CD_PRV');
    }

    public function etablissements(): HasMany
    {
        return $this->hasMany(Etablisement::class, 'cd_commune', 'CD_COM');
    }

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class, 'ville_id', 'CD_COM');
    }
}

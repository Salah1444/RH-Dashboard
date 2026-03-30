<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    protected $table      = 'commune';
    protected $primaryKey = 'id_commune';

    protected $fillable = [
        'CD_COM', 'LIB_COMMUNE_FR', 'LIB_COMMUNE_AR',
        'LIB_MILIEU_FR', 'LIB_MILIEU_AR', 'id_province',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'id_province', 'id_province');
    }

    public function etablissements(): HasMany
    {
        return $this->hasMany(Etablisement::class, 'commune_id', 'id_commune');
    }

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class, 'ville_id', 'id_commune');
    }
}

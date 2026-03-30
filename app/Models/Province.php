<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table      = 'province';
    protected $primaryKey = 'id_province';

    protected $fillable = ['CD_PRV', 'LIB_PROVINCE_FR', 'LIB_PROVINCE_AR', 'id_region'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }

    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class, 'id_province', 'id_province');
    }
}

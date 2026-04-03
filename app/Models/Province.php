<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table      = 'province';
        protected $primaryKey = 'CD_PRV';

    protected $fillable = ['LIB_PROVINCE_FR', 'LIB_PROVINCE_AR', 'CD_REG'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'CD_REG', 'CD_REG');
    }

    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class, 'CD_PRV', 'CD_PRV');
    }
}

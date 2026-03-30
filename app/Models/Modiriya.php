<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modiriya extends Model
{
    protected $table      = 'modiriya';
    protected $primaryKey = 'modiriya_id';

    protected $fillable = ['nom_modiriya', 'id_region'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }

    public function etablissements(): HasMany
    {
        return $this->hasMany(Etablisement::class, 'modiriya_id', 'modiriya_id');
    }
}

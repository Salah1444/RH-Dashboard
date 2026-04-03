<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $table      = 'position';
        protected $primaryKey = 'COD_POS';

    protected $fillable = [
        'LIB_POSITION_FR', 'LIB_POSITION_AR',
        'LIB_TYPE_POSITION_FR', 'LIB_TYPE_POSITION_AR',
        'DATE_POSITION',
    ];

    protected $casts = ['DATE_POSITION' => 'date'];

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class, 'position_id', 'COD_POS');
    }
}

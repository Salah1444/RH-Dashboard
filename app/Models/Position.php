<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $table      = 'position';
    protected $primaryKey = 'id_position';

    protected $fillable = [
        'COD_POS', 'LIB_POSITION_FR', 'LIB_POSITION_AR',
        'LIB_TYPE_POSITION_FR', 'LIB_TYPE_POSITION_AR',
        'DATE_POSITION', 'type_position',
    ];

    protected $casts = ['DATE_POSITION' => 'date'];

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class, 'position_id', 'id_position');
    }
}

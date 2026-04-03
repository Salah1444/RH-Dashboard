<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Congee extends Model
{
    protected $table      = 'congee';
    protected $primaryKey = 'id_congee';

    protected $fillable = ['type_congee', 'date_debut', 'date_fin', 'nombre_jrs'];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class, 'congee_id', 'id_congee');
    }
}

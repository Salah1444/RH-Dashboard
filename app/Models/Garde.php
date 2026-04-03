<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Garde extends Model
{
    protected $table      = 'garde';
    protected $primaryKey = 'id_garde';

    protected $fillable = [
        'date_garde', 'nom_prenom_gardeur',
        'doti_gardeur', 'cin_gardeur', 'fonction_gardeur',
    ];

    protected $casts = ['date_garde' => 'date'];

    public function enfants(): HasMany
    {
        return $this->hasMany(Enfant::class, 'gard_id', 'id_garde');
    }
}

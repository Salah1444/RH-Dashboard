<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enfant extends Model
{
    protected $table      = 'enfants';
    protected $primaryKey = 'id_enf';

    protected $fillable = [
        'code_agent', 'gard_id', 'nom_enf', 'prenom',
        'rang_enf', 'date_naissance_enf',
        'lien_juridique', 'situation_enf',
    ];

    protected $casts = ['date_naissance_enf' => 'date'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG');
    }

    public function garde(): BelongsTo
    {
        return $this->belongsTo(Garde::class, 'gard_id', 'id_garde');
    }
}

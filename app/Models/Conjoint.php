<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conjoint extends Model
{
    protected $table      = 'conjoints';
    protected $primaryKey = 'id_conj';

    protected $fillable = [
        'emp_id', 'DATE_SIT_FAM', 'nom_prenom_conjoint',
        'rang_conj', 'cin_conj', 'doti_conj',
        'nationalite_conj', 'fonction_conj',
    ];

    protected $casts = ['DATE_SIT_FAM' => 'date'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'emp_id', 'id_emp');
    }
}

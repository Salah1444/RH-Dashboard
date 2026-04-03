<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    protected $table      = 'absence';
    protected $primaryKey = 'id_abs';

    protected $fillable = [
        'code_agent', 'congee_id',
        'date_debut', 'date_fin', 'is_justify', 'certificat',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG');
    }

    public function congee(): BelongsTo
    {
        return $this->belongsTo(Congee::class, 'congee_id', 'id_congee');
    }
}

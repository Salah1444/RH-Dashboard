<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    protected $table      = 'absence';
    protected $primaryKey = 'id_abs';

    protected $fillable = [
        'emp_id', 'congee_id',
        'date_debut', 'date_fin', 'motif', 'certificat',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'emp_id', 'id_emp');
    }

    public function congee(): BelongsTo
    {
        return $this->belongsTo(Congee::class, 'congee_id', 'id_congee');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diplome extends Model
{
    protected $table      = 'diplomes';
    protected $primaryKey = 'id_diplome';

    protected $fillable = [
        'code_agent', 'CD_DIPP', 'LL_DIP',
        'DT_DIP', 'etablissement_formation',
        'montion', 'type_dip', 'date_obtenue', 'PDF',
    ];

    protected $casts = [
        'DT_DIP'       => 'date',
        'date_obtenue' => 'date',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG');
    }
}

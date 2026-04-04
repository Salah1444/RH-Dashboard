<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diplome extends Model
{
    protected $table      = 'diplomes';
    protected $primaryKey = 'CD_DIP';
    protected $fillable = [
        'LL_DIP', 'etablissement_formation',
        'DT_DIP', 'TYPE_DIP', 'montion',
        'code_agent', 'PDF',
    ];

    protected $casts = [
        'DT_DIP' => 'date',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG');
    }
}

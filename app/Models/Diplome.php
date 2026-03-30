<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diplome extends Model
{
    protected $table      = 'diplomes';
    protected $primaryKey = 'id_diplome';

    protected $fillable = [
        'emp_id', 'CD_DIPP', 'LL_DIPP', 'CD_DIPS', 'LL_DIPS',
        'DT_DIPPROF', 'DT_DIPSCOL', 'etablissement_formation',
        'specialite_montion', 'type_dip', 'date_obtenue',
    ];

    protected $casts = [
        'DT_DIPPROF'   => 'date',
        'DT_DIPSCOL'   => 'date',
        'date_obtenue' => 'date',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'emp_id', 'id_emp');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Affectation extends Model
{
    protected $table      = 'affectation';
    protected $primaryKey = 'id_aff';

    protected $fillable = [
        'code_agent', 'code_etab', 'fonction_id',
        'DT_AFF_POSTE', 'DATE_DEBUT_AFF',
        'Date_aff_delegation', 'Date_aff_aref',
        'Mode_Affectation',
    ];

    protected $casts = [
        'DT_AFF_POSTE'        => 'date',
        'DATE_DEBUT_AFF'      => 'date',
        'Date_aff_delegation' => 'date',
        'Date_aff_aref'       => 'date',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG');
    }

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablisement::class, 'code_etab', 'CD_ETAB');
    }

    public function fonction(): BelongsTo
    {
        return $this->belongsTo(Fonction::class, 'fonction_id', 'CODE_FONCTION');
    }
}

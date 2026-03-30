<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Affectation extends Model
{
    protected $table      = 'affectation';
    protected $primaryKey = 'id_aff';

    protected $fillable = [
        'emp_id', 'etablissement_id', 'fonction_id',
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
        return $this->belongsTo(Employer::class, 'emp_id', 'id_emp');
    }

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablisement::class, 'etablissement_id', 'id_etablisement');
    }

    public function fonction(): BelongsTo
    {
        return $this->belongsTo(Fonction::class, 'fonction_id', 'id_fon');
    }
}

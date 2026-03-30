<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etablisement extends Model
{
    protected $table      = 'etablisement';
    protected $primaryKey = 'id_etablisement';

    protected $fillable = [
        'CD_ETAB', 'LIBELLE_FR_AFF', 'LIBELLE_AR_AFF', 'type_milieu',
        'Nombre_eleves', 'Disponibilite_logement',
        'commune_id', 'modiriya_id', 'net_etab_id',
    ];

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id', 'id_commune');
    }

    public function modiriya(): BelongsTo
    {
        return $this->belongsTo(Modiriya::class, 'modiriya_id', 'modiriya_id');
    }

    public function netEtab(): BelongsTo
    {
        return $this->belongsTo(NetEtab::class, 'net_etab_id', 'net_etab_id');
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class, 'etablissement_id', 'id_etablisement');
    }
}

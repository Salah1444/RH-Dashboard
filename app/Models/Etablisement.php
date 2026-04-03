<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etablisement extends Model
{
    protected $table      = 'etablisement';
        protected $primaryKey = 'CD_ETAB';

    protected $fillable = [
        'NOM_ETAB', 'type_milieu',
        'Nombre_eleves', 'Disponibilite_logement',
        'cd_commune', 'modiriya_id', 'CD_NETAB',
    ];

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'cd_commune', 'CD_COM');
    }

    public function modiriya(): BelongsTo
    {
        return $this->belongsTo(Modiriya::class, 'modiriya_id', 'modiriya_id');
    }

    public function netEtab(): BelongsTo
    {
        return $this->belongsTo(NetEtab::class, 'CD_NETAB', 'CD_NETAB');
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class, 'code_etab', 'CD_ETAB');
    }
}

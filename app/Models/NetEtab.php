<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NetEtab extends Model
{
    protected $table      = 'net_etab';
    protected $primaryKey = 'net_etab_id';

    protected $fillable = ['CD_NETAB', 'LIBELLE_net_etab'];

    public function etablissements(): HasMany
    {
        return $this->hasMany(Etablisement::class, 'net_etab_id', 'net_etab_id');
    }
}

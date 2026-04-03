<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NetEtab extends Model
{
    protected $table      = 'net_etab';
        protected $primaryKey = 'CD_NETAB';

    protected $fillable = ['LIBELLE_net_etab'];

    public function etablissements(): HasMany
    {
        return $this->hasMany(Etablisement::class, 'CD_NETAB', 'CD_NETAB');
    }
}

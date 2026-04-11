<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NetEtab extends Model
{
    protected $table = 'net_etab';
    protected $primaryKey = 'CD_NETAB';
    protected $fillable = ['LIBELLE_net_etab'];
    public function etablissements()
    {
        return $this->HasMany(Etablissement::class, 'CD_NETAB', 'CD_NETAB');
    }
}

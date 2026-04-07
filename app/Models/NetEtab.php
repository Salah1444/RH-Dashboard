<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NetEtab extends Model {
    protected $table = 'net_etab';
    protected $primaryKey = 'CD_NETAB';
    protected $fillable = ['LIBELLE_net_etab'];
}

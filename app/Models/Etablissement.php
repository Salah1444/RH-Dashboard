<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model {
    protected $table = 'etablissement';
    protected $primaryKey = 'CD_ETAB';
    protected $fillable = [
        'NOM_ETAB', 'type_milieu', 'Nombre_eleves',
        'Disponibilite_logement', 'cd_commune', 'modiriya_id', 'CD_NETAB',
    ];
    public function commune()      { return $this->belongsTo(Commune::class, 'cd_commune', 'CD_COM'); }
    public function modiriya()     { return $this->belongsTo(Modiriya::class, 'modiriya_id', 'modiriya_id'); }
    public function netEtab()      { return $this->belongsTo(NetEtab::class, 'CD_NETAB', 'CD_NETAB'); }
    public function affectations() { return $this->hasMany(Affectation::class, 'code_etab', 'CD_ETAB'); }
}

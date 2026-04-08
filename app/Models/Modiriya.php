<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Modiriya extends Model {
    protected $table = 'modiriya';
    protected $primaryKey = 'modiriya_id';
    protected $fillable = ['nom_modiriya', 'id_region'];
    public function region()         { return $this->belongsTo(Region::class, 'id_region', 'CD_REG'); }
    public function etablissements() { return $this->hasMany(Etablisement::class, 'modiriya_id', 'modiriya_id'); }
}

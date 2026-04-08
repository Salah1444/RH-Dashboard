<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model {
    protected $table = 'commune';
    protected $primaryKey = 'CD_COM';
    protected $fillable = ['LIB_COMMUNE_FR', 'LIB_COMMUNE_AR', 'LIB_MILIEU_FR', 'LIB_MILIEU_AR', 'CD_PRV'];
    public function province()  { return $this->belongsTo(Province::class, 'CD_PRV', 'CD_PRV'); }
    public function employers() { return $this->hasMany(Employer::class, 'ville_id', 'CD_COM'); }
}

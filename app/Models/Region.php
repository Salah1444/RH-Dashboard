<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Region extends Model {
    protected $table = 'region';
    protected $primaryKey = 'CD_REG';
    protected $fillable = ['LIB_REGION_FR', 'LIB_REGION_AR'];
    public function provinces()  { return $this->hasMany(Province::class, 'CD_REG', 'CD_REG'); }
    public function modiriyas()  { return $this->hasMany(Modiriya::class, 'id_region', 'CD_REG'); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Province extends Model {
    protected $table = 'province';
    protected $primaryKey = 'CD_PRV';
    protected $fillable = ['LIB_PROVINCE_FR', 'LIB_PROVINCE_AR', 'CD_REG'];
    public function region()   { return $this->belongsTo(Region::class, 'CD_REG', 'CD_REG'); }
    public function communes() { return $this->hasMany(Commune::class, 'CD_PRV', 'CD_PRV'); }
}

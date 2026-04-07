<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cadre extends Model {
    protected $table = 'cadre';
    protected $primaryKey = 'id_cadre';
    protected $fillable = ['CADRE', 'Lib_cadre_AR', 'Lib_Cadre_FR'];
    public function histories() { return $this->hasMany(EmployeCadreHistory::class, 'id_cadre', 'id_cadre'); }
}

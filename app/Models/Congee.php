<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Congee extends Model {
    protected $table = 'congee';
    protected $primaryKey = 'id_congee';
    protected $fillable = ['type_congee', 'date_debut', 'date_fin', 'nombre_jrs'];
    public function absences() { return $this->hasMany(Absence::class, 'congee_id', 'id_congee'); }
}

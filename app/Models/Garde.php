<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Garde extends Model {
    protected $table = 'garde';
    protected $primaryKey = 'id_garde';
    protected $fillable = ['date_garde', 'nom_prenom_gardeur', 'doti_gardeur', 'cin_gardeur', 'fonction_gardeur'];
    public function enfants() { return $this->hasMany(Enfant::class, 'gard_id', 'id_garde'); }
}

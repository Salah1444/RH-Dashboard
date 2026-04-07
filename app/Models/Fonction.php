<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model {
    protected $table = 'fonction';
    protected $primaryKey = 'CODE_FONCTION';
    protected $fillable = [
        'LIB_FONCTION_FR', 'LIB_FONCTION_AR',
        'DT_AFF_Fonction', 'LL_CYCLE', 'LL_DISCIP',
    ];
    public function affectations() { return $this->hasMany(Affectation::class, 'fonction_id', 'CODE_FONCTION'); }
}

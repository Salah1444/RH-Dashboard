<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmployeCadreHistory extends Model {
    protected $table = 'employe_cadre_history';
    protected $fillable = ['code_agent', 'id_cadre', 'ANC_ADM', 'DT_AFF_Cadre'];
    public function employer() { return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG'); }
    public function cadre()    { return $this->belongsTo(Cadre::class,    'id_cadre',   'id_cadre'); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmployeGradesHistory extends Model {
    protected $table = 'employe_grades_history';
    protected $fillable = ['code_agent', 'id_grade', 'ANC_GRADE', 'DAT_EFF_GR', 'MOD_AV_GRADE', 'LIBELLE_GRADE'];
    public function employer() { return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG'); }
    public function grade()    { return $this->belongsTo(Grade::class,    'id_grade',   'id_grade'); }
}

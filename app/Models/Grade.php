<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model {
    protected $table = 'grade';
    protected $primaryKey = 'id_grade';
    protected $fillable = ['GRADE', 'Lib_grade_AR', 'Lib_grade_FR'];
    public function histories() { return $this->hasMany(EmployeGradesHistory::class, 'id_grade', 'id_grade'); }
}

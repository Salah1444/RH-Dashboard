<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    protected $table      = 'grade';
    protected $primaryKey = 'id_grade';

    protected $fillable = ['GRADE', 'Lib_grade_AR', 'Lib_grade_FR'];

    public function history(): HasMany
    {
        return $this->hasMany(EmployeGradeHistory::class, 'id_grade', 'id_grade');
    }
}

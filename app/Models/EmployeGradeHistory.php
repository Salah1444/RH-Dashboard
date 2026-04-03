<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeGradeHistory extends Model
{
    protected $table = 'employe_grades_history';

    protected $fillable = [
        'code_agent', 'id_grade', 'ANC_GRADE',
        'DAT_EFF_GR', 'MOD_AV_GRADE', 'LIBELLE_GRADE',
    ];

    protected $casts = ['DAT_EFF_GR' => 'date'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG');
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'id_grade', 'id_grade');
    }
}

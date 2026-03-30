<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeEchelonHistory extends Model
{
    protected $table = 'employe_echelon_history';

    protected $fillable = ['emp_id', 'id_ech', 'INDICE', 'ANC_ELO', 'DAT_EFF_ELO'];

    protected $casts = ['DAT_EFF_ELO' => 'date'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'emp_id', 'id_emp');
    }

    public function echelon(): BelongsTo
    {
        return $this->belongsTo(Echelon::class, 'id_ech', 'id_ech');
    }
}

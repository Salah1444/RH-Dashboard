<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeCadreHistory extends Model
{
    protected $table = 'employe_cadre_history';

    protected $fillable = ['emp_id', 'id_cadre', 'ANC_ADM', 'DT_AFF_Cadr'];

    protected $casts = ['DT_AFF_Cadr' => 'date'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'emp_id', 'id_emp');
    }

    public function cadre(): BelongsTo
    {
        return $this->belongsTo(Cadre::class, 'id_cadre', 'id_cadre');
    }
}

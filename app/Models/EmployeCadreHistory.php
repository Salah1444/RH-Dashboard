<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeCadreHistory extends Model
{
    protected $table = 'employe_cadre_history';

    protected $fillable = ['code_agent', 'id_cadre', 'ANC_ADM', 'DT_AFF_Cadre'];

    protected $casts = ['DT_AFF_Cadre' => 'date'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG');
    }

    public function cadre(): BelongsTo
    {
        return $this->belongsTo(Cadre::class, 'id_cadre', 'id_cadre');
    }
}

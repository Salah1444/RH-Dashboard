<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Diplome extends Model {
    protected $table = 'diplomes';
    protected $primaryKey = 'CD_DIP';
    protected $fillable = [
        'LL_DIP', 'DT_DIP', 'code_agent',
        'etablissement_formation', 'montion', 'TYPE_DIP', 'PDF',
    ];
    public function employer() { return $this->belongsTo(Employer::class, 'code_agent', 'COD_AG'); }
}

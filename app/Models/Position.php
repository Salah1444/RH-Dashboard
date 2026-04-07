<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Position extends Model {
    protected $table = 'position';
    protected $primaryKey = 'COD_POS';
    protected $fillable = [
        'LIB_POSITION_FR', 'LIB_POSITION_AR',
        'LIB_TYPE_POSITION_FR', 'LIB_TYPE_POSITION_AR', 'DATE_POSITION',
    ];
    public function employers() { return $this->hasMany(Employer::class, 'position_id', 'COD_POS'); }
}

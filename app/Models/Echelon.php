<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Echelon extends Model {
    protected $table = 'echelon';
    protected $primaryKey = 'id_ech';
    protected $fillable = ['COD_ECH', 'COD_ELO'];
}

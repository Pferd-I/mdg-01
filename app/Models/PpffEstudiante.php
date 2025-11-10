<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpffEstudiante extends Model
{
    use HasFactory;
    protected $fillable = ['id_estudiante', 'id_ppff', 'parentesco', 'estado'];
    //Llaves foráneas
    public function ppff(){
        return $this->belongsTo(Ppff::class,'id_ppff');
    }
    public function estudiante(){
        return $this->belongsTo(Estudiante::class,'id_estudiante');
    }
}

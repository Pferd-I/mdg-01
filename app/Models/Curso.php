<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model{
    use HasFactory;
    protected $fillable = ['grado', 'nro_grado', 'id_nivel', 'id_paralelo', 'gestion', 'estado'];
    //Llaves foráneas
    public function nivel(){
        return $this->belongsTo(Nivel::class,'id_nivel');
    }
    public function paralelo(){
        return $this->belongsTo(Paralelo::class,'id_paralelo');
    }
    //Referencias de otras tablas
    public function estudiantes(){
        return $this->hasMany(Estudiante::class, 'id_curso');
    }
}

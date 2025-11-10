<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppff extends Model{
    use HasFactory;
    protected $fillable = ['cionit', 'nombre'];
    //Referencias de otras tablas
    public function contactos(){
        return $this->hasMany(Contacto::class, 'id_ppff');
    }
    public function estudiantes(){
        return $this->belongsToMany(Estudiante::class, 'ppff_estudiantes', 'id_ppff', 'id_estudiante')
        ->withPivot('parentesco');
    }
}

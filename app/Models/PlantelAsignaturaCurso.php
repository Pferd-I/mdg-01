<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantelAsignaturaCurso extends Model{
    use HasFactory;
    protected $fillable = [
        'id_plantel',
        'id_asignatura',
        'id_curso',
    ];
    //Llaves Foráneas
    public function plantel(){
        return $this->belongsTo(Plantel::class, 'id_plantel');
    }
    public function asignatura(){
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }
    public function curso(){
        return $this->belongsTo(Curso::class, 'id_curso');
    }
    //Referencia de otras tablas
    public function asistencias(){
        return $this->hasMany(Asistencia::class, 'id_plantel_asignatura_curso');
    }
}

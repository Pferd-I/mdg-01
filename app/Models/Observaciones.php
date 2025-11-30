<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model{
    use HasFactory;
    protected $fillable = [
        'id_plantel',
        'id_estudiante',
        'tipo',
        'descripcion',
        'id_curso',
        'asignatura',
        'fecha_evento',
        'estado'
    ];
    protected $casts = [
        'fecha_evento' => 'date:d-m-Y',
    ];
    // Llaves foráneas
    public function estudiante(){
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }
    public function plantel(){
        return $this->belongsTo(Plantel::class, 'id_plantel');
    }
    public function curso(){
        return $this->belongsTo(Curso::class, 'id_curso');
    }
    public function getUsuarioAttribute(){
        return $this->plantel?->user;
    }


    // Tipos permitidos
    public static function tipos(){
        return [
            'Académico' => 'Rendimiento en las clases.',
            'Asistencia' => 'Presencia en aula.',
            'Disciplina' => 'Comportamiento dentro de la institución.',
            'Retiro' => 'Retiro a mitad de clase.',
            'Tareas' => 'Incumplimiento en entrega de tareas.',
            'Otro' => 'Situación particular dentro o en las cercanías de la institución.',
        ];
    }
}

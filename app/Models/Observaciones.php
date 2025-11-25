<?php

namespace App\Models;

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
        'fecha_evento' => 'date',
    ];

    // Llaves foráneas
    public function estudiante(){
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }
    public function plantel(){
        return $this->belongsTo(User::class, 'id_plantel');
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
            'Ausencia' => 'No se presentó a clase.',
            'Tareas' => 'Incumplimiento en entrega de tareas.',
            'Indisciplina' => 'Comportamiento inapropiado.',
            'Retiro' => 'Retiro a mitad de clase.',
            'Aprovechamiento' => 'Aprovechamiento académico.',
        ];
    }
}

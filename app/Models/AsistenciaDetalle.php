<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaDetalle extends Model{
    use HasFactory;
    protected $fillable = [
        'id_asistencia',
        'id_estudiante',
        'valor',
        'observacion_individual',
        'estado',
    ];
    //Llaves Foráneas
    public function asistencia(){
        return $this->belongsTo(Asistencia::class, 'id_asistencia');
    }
    public function estudiante(){
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }
    // Tipos permitidos
    public static function tipos(){
        return [
            'Presente' => 'Asistencia normal del estudiante.',
            'Atraso' => 'Asistencia con retraso del estudiante.',
            'Ausente' => 'Falta de asistencia del estudiante.',
            'Justificado' => 'Falta de asistencia del estudiante con justificación válida.',
        ];
    }
}

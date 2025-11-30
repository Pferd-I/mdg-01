<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model{
    use HasFactory;
    protected $fillable = [
        'id_plantel',
        'id_curso',
        'id_asignatura',
        'fecha',
        'observaciones',
    ];
    //Llave Foránea
    public function plantel(){
        return $this->belongsTo(Plantel::class, 'id_plantel');
    }

    public function curso(){
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function asignatura(){
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }
    //Referencia de otras tablas
    public function detalles(){
        return $this->hasMany(AsistenciaDetalle::class);
    }
}

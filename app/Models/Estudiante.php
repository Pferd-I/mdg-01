<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{
    use HasFactory;
    protected $fillable = ['ci','rude','apellido_p','apellido_m','nombres','id_tipo_beca','id_curso','estado'];
    //Llaves Foráneas
    public function curso(){
        return $this->belongsTo(Curso::class,'id_curso');
    }
    public function tipo_beca(){
        return $this->belongsTo(TipoBeca::class,'id_tipo_beca');
    }
    //Referencias de otras tablas
    public function padres(){
        return $this->belongsToMany(Ppff::class, 'ppff_estudiantes',
            'id_estudiante', 'id_ppff')
            ->withPivot('parentesco');
    }
    public function observaciones(){
        return $this->hasMany(Observaciones::class, 'id_estudiante');
    }
    public function asistenciasDetalles(){
        return $this->hasMany(AsistenciaDetalle::class, 'id_estudiante');
    }
}

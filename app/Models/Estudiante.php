<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{
    use HasFactory;
    protected $fillable = ['ci','rude','apellido_p','apellido_m','nombres','id_tipo_beca','id_curso','estado'];
    public function curso(){
        return $this->belongsTo(Curso::class,'id_curso');
    }
    public function tipo_beca(){
        return $this->belongsTo(TipoBeca::class,'id_tipo_beca');
    }
}

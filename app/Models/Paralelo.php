<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model{
    use HasFactory;
    protected $fillable = ['nombre_paralelo','estado'];
    //Referencias de otras tablas
    public function cursos(){
        return $this->hasMany(Curso::class, 'id_paralelo');
    }
}

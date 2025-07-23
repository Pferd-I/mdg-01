<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model{
    use HasFactory;
    protected $fillable = ['grado', 'nro_grado', 'id_nivel', 'id_paralelo', 'gestion', 'estado'];
}

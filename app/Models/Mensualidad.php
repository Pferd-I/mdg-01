<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model{
    use HasFactory;
    protected $fillable = ['nro_mes', 'nombre_mes', 'id_gestion', 'monto', 'estado'];
    public function gestion(){
        return $this->belongsTo(Gestion::class, 'id_gestion');
    }
}

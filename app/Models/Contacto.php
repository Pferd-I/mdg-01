<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model{
    use HasFactory;
    protected $fillable = ['id_ppff', 'nro_telf', 'direccion', 'tipo_contacto', 'estado'];
    //Llave foránea
    public function ppff(){
        return $this->belongsTo(PPFF::class,'id_ppff');
    }
}

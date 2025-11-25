<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model{
    use HasFactory;
    protected $table = 'cargos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];
    //Tabla Relacionada Cargo_Plantel
    public function personal(){
        return $this->belongsToMany(Plantel::class, 'cargo_plantels',
            'id_cargo', 'id_plantel')
            ->withTimestamps();
    }
}

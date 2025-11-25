<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantel extends Model{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'estado',
        'id_user',
    ];
    //Llavea Foráneas
    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
    //Tabla Relacionada Cargo_Plantel
    public function cargos(){
        return $this->belongsToMany(Cargo::class, 'cargo_plantels',
            'id_plantel', 'id_cargo')
            ->withPivot('fecha_asignacion')->withTimestamps();
    }
    public function observaciones(){
        return $this->hasMany(Observaciones::class, 'id_plantel');
    }
}

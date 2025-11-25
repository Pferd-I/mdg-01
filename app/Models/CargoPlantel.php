<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoPlantel extends Model{
    use HasFactory;
    protected $fillable = [
        'id_plantel',
        'id_cargo',
        'fecha_asignacion'
    ];
    //Llaves Foráneas
    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    public function plantel(){
        return $this->belongsTo(Plantel::class);
    }
}

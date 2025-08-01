<?php

namespace App\Http\Controllers;

use App\Http\Resources\TipoBecaResource;
use App\Models\TipoBeca;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MensualidadController extends Controller
{
    public function index(){
        return Inertia::render('Admin/Mensualidades/MensualidadIndex',[
            'tipobecas' => TipoBecaResource::collection(TipoBeca::all()),
        ]);
    }
}

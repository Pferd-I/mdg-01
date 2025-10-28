<?php

namespace App\Http\Controllers;

use App\Http\Resources\GestionResource;
use App\Http\Resources\TipoBecaResource;
use App\Http\Resources\MensualidadResource;
use App\Models\Gestion;
use App\Models\TipoBeca;
use App\Models\Mensualidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class MensualidadController extends Controller{
    public function index(){
        return Inertia::render('Admin/Mensualidades/MensualidadIndex',[
            'tipobecas' => TipoBecaResource::collection(TipoBeca::all()),
            'gestiones' => GestionResource::collection(Gestion::all()),
            'mensualidades' => MensualidadResource::collection(Mensualidad::all()),
        ]);
    }
    public function mensualidades(Gestion $gestion){
    /*return response()->json(DB::table('mensualidads AS M')
                    ->leftJoin('gestions As G','M.gestion','=','G.gestion')
                    ->select('M.nro_mes','M.nombre_mes','M.gestion', 'M.monto', 'M.estado')
                    ->where('G.id', '=', $gestion->id)
                    ->get());*/
        return response()->json($gestion->mensualidades()->get());
}
}

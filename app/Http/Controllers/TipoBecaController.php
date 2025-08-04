<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateTipoBecaRequest;
use App\Models\TipoBeca;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TipoBecaController extends Controller{
    public function update(CreateTipoBecaRequest $request, TipoBeca $tipo_beca){
        //$tipoBeca->update($request->validated());
        /*$request->validate([
            'nombre_tipo_beca' => 'required',
            'descripcion' => 'string',
            'dcto' => 'required',
            'estado' => 'required',
        ]);*/
        /*$tipoBeca->update([
            'nombre_tipo_beca' => $request->nombre_tipo_beca,
            'descripcion' => $request->descripcion,
            'dcto' => $request->dcto,
            'estado' => $request->estado,
        ]);*/
        /*Flight::where('active', 1)
    ->where('destination', 'San Diego')
    ->update(['delayed' => 1]);*/
        TipoBeca::where('id', $request->id)->update([
            'nombre_tipo_beca' => $request->nombre_tipo_beca,
            'descripcion' => $request->descripcion,
            'dcto' => $request->dcto,
            'estado' => $request->estado,
        ]);
    }

    public function store(CreateTipoBecaRequest $request){
        TipoBeca::create($request->validated());
    }
}

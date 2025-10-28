<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CreateGestionMensController extends Controller{
    public function __invoke(Request $request){
        Gestion::create($request->validate([
            'gestion' => ['required', 'numeric', Rule::unique('gestions','gestion')->ignore($request->gestion)],
        ]));

        DB::table('mensualidads')->insert([
            ['nro_mes' => 1, 'gestion' => $request->gestion, 'nombre_mes' => 'Febrero', 'monto' => $request->monto,],
            ['nro_mes' => 2, 'gestion' => $request->gestion, 'nombre_mes' => 'Marzo', 'monto' => $request->monto,],
            ['nro_mes' => 3, 'gestion' => $request->gestion, 'nombre_mes' => 'Abril', 'monto' => $request->monto,],
            ['nro_mes' => 4, 'gestion' => $request->gestion, 'nombre_mes' => 'Mayo', 'monto' => $request->monto,],
            ['nro_mes' => 5, 'gestion' => $request->gestion, 'nombre_mes' => 'Junio', 'monto' => $request->monto,],
            ['nro_mes' => 6, 'gestion' => $request->gestion, 'nombre_mes' => 'Julio', 'monto' => $request->monto,],
            ['nro_mes' => 7, 'gestion' => $request->gestion, 'nombre_mes' => 'Agosto', 'monto' => $request->monto,],
            ['nro_mes' => 8, 'gestion' => $request->gestion, 'nombre_mes' => 'Septiembre', 'monto' => $request->monto,],
            ['nro_mes' => 9, 'gestion' => $request->gestion, 'nombre_mes' => 'Octubre', 'monto' => $request->monto,],
            ['nro_mes' => 10, 'gestion' => $request->gestion, 'nombre_mes' => 'Noviembre', 'monto' => $request->monto,],
        ]);
    }
}

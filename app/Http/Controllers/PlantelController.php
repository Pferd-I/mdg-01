<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Plantel;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlantelController extends Controller{
    public function index(){
        return Inertia::render('Admin/Plantel/PlantelIndex', [
            'plantel' => Plantel::with('cargos')->get(),
            'cargos'  => Cargo::where('estado', true)->get(),
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|boolean',
            'id_user' => 'nullable|exists:users,id',
            'cargos' => 'array',
            'cargos.*' => 'exists:cargos,id',
        ]);

        $plantel = Plantel::create([
            'nombre' => $request->nombre,
            'estado' => $request->estado,
            'id_user' => $request->id_user,
        ]);

        // Guardar tabla cargo_plantels
        if ($request->cargos) {
            $plantel->cargos()->sync($request->cargos);
        }

        return back()->with('success', 'Miembro del plantel registrado correctamente.');
    }
    public function show($id){
        $plantel = Plantel::with('cargos')->findOrFail($id);
        $plantel->todos_cargos = Plantel::all();

        return Inertia::render('@/Components/Plantel/PlantelModalInfo.vue', [
            'estudiante' => $plantel,
        ]);
    }
    public function getPlantel($id){
        $plantel = Plantel::with('cargos')->findOrFail($id);
        $cargos = Cargo::all();
        return response()->json([
            'plantel' => $plantel,
            'cargos' => $cargos,
        ]);
    }
    public function addCargo(Request $request, $id){
        $request->validate([
            'id_cargo' => 'required|exists:cargos,id'
        ]);

        $plantel = Plantel::findOrFail($id);

        if (!$plantel->cargos()->where('id_cargo', $request->id_cargo)->exists()) {
            $plantel->cargos()->attach($request->id_cargo, [
                'fecha_asignacion' => now(),
            ]);
        }
        return back();
    }
    public function removeCargo($id_plantel, $id_cargo){
        $plantel = Plantel::findOrFail($id_plantel);
        $plantel->cargos()->detach($id_cargo);
        return back();
    }
    public function update(Request $request, $id){
        $plantel = Plantel::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|boolean',
            /*'id_user' => 'nullable|exists:users,id',
            'cargos' => 'array',
            'cargos.*' => 'exists:cargos,id',*/
        ]);

        $plantel->update([
            'nombre' => $request->nombre,
            'estado' => $request->estado,
            /*'id_user' => $request->id_user,*/
        ]);

        //$plantel->cargos()->sync($request->cargos ?? []);
        return back()->with('success', 'Datos actualizados correctamente.');
    }
    public function destroy($id){
        $plantel = Plantel::findOrFail($id);
        $plantel->cargos()->detach();
        $plantel->delete();

        return back()->with('success', 'Miembro eliminado del plantel.');
    }
    public function getUsuario($id){
        $plantel = Plantel::with('user')->findOrFail($id);

        $usuarioActualId = $plantel->id_user;
        $usuarios = User::whereDoesntHave('plantel')
        ->orWhere('id', $usuarioActualId)
        ->select('id', 'name', 'email')
        ->get();

        return response()->json([
            'usuario' => $plantel->user,
            'usuarios' => $usuarios,
        ]);
    }

    public function assignUsuario(Request $request, $id){
        $plantel = Plantel::findOrFail($id);
        $request->validate([
            'id_user' => 'required|exists:users,id'
        ]);

        $plantel->id_user = $request->id_user;
        $plantel->save();

        return back()->with('success', 'Usuario asignado correctamente');
    }

    public function removeUsuario($id){
        $plantel = Plantel::findOrFail($id);
        $plantel->id_user = null;
        $plantel->save();

        return back()->with('success', 'Usuario eliminado');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Ppff;
use App\Models\TipoBeca;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EstudianteController extends Controller{
    public function index(Request $request){

        $query = Estudiante::with(['curso.nivel', 'tipo_beca','padres']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'like', "%$search%")
                  ->orWhere('apellido_p', 'like', "%$search%")
                  ->orWhere('apellido_m', 'like', "%$search%")
                  ->orWhere('ci', 'like', "%$search%")
                  ->orWhere('rude', 'like', "%$search%");
            });
        }

        $estudiantes = $query->get();
        //$cursos = Curso::all();
        $cursos = Curso::with('paralelo','nivel')->get();
        $tipos_beca = TipoBeca::all();

        return Inertia::render('Admin/Estudiantes/EstudianteIndex',[
            'estudiantes' => $estudiantes,
            'cursos' => $cursos,
            'tiposbeca' => $tipos_beca,
            'search' => $request->search,
        ]);
    }

    public function show($id){
        $estudiante = Estudiante::with(['curso.nivel', 'tipo_beca', 'padres'])->findOrFail($id);
        $estudiante->todos_padres = Ppff::all();

        return Inertia::render('@/Components/Estudiantes/EstudianteModalInfo.vue', [
            'estudiante' => $estudiante,
        ]);
    }
    public function getEstudiante($id){
        $estudiante = Estudiante::with(['curso.nivel', 'tipo_beca', 'padres.contactos'])->findOrFail($id);
        $padres = Ppff::all();

        return response()->json([
            'estudiante' => $estudiante,
            'padres' => $padres,
        ]);
    }
    public function addPpff(Request $request, $id, $par){
        $request->validate([
            'id_ppff' => 'required|exists:ppffs,id'
        ]);

        $estudiante = Estudiante::findOrFail($id);

        if (!$estudiante->padres()->where('id_ppff', $request->id_ppff)->exists()) {
            $estudiante->padres()->attach($request->id_ppff,
            ['parentesco'=>$par]);
        }
        return back();
    }
    public function removePpff($id_estudiante, $id_ppff){
        $estudiante = Estudiante::findOrFail($id_estudiante);
        $estudiante->padres()->detach($id_ppff);
        return back();
    }
    public function store(Request $request){
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:estudiantes,ci',
            'rude' => 'nullable|string|max:30|unique:estudiantes,rude',
            'apellido_p' => 'required|string|max:50',
            'apellido_m' => 'nullable|string|max:50',
            'nombres' => 'required|string|max:100',
            'id_curso' => 'required|exists:cursos,id',
            'id_tipo_beca' => 'nullable|exists:tipo_becas,id',
        ]);
        $estudiante = Estudiante::create($validated);
        return redirect()->back()->with('success', 'Estudiante creado correctamente.');
    }
}

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
            'tipos_beca' => $tipos_beca,
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
        ], $this->messages());

        $estudiante = Estudiante::create($validated);
        return redirect()->back()->with('success', 'Estudiante creado correctamente.');
    }
    public function update(Request $request, $id){
        $estudiante = Estudiante::findOrFail($id);
        $validated = $request->validate([
        'ci' => 'required|string|max:20|unique:estudiantes,ci,' . $id,
        'rude' => 'nullable|string|max:30|unique:estudiantes,rude,' . $id,
            'apellido_p' => 'required|string|max:50',
            'apellido_m' => 'nullable|string|max:50',
            'nombres' => 'required|string|max:100',
            'id_curso' => 'required|exists:cursos,id',
            'id_tipo_beca' => 'nullable|exists:tipo_becas,id',
        ], $this->messages());

        $estudiante->update($validated);
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante editado correctamente.');
    }
    public function inhabilitar($id)
{
    $est = Estudiante::findOrFail($id);
    $est->estado = !$est->estado;
    $est->save();

    $mensaje = $est->estado ? 'Estudiante habilitado nuevamente.' : 'Estudiante inhabilitado.';

    return back()->with($est->estado ? 'success':'error' , $mensaje);
}
    public function messages(){
        return [
            'ci.required' => 'El campo CI es obligatorio.',
            'ci.unique' => 'Ya existe un estudiante con ese CI.',
            'ci.max' => 'El CI no debe exceder los 20 caracteres.',
            'rude.unique' => 'El RUDE ingresado ya está registrado.',
            'rude.max' => 'El RUDE no debe exceder los 30 caracteres.',
            'apellido_p.required' => 'El apellido paterno es obligatorio.',
            'apellido_p.max' => 'El apellido paterno no debe exceder los 50 caracteres.',
            'apellido_m.max' => 'El apellido materno no debe exceder los 50 caracteres.',
            'nombres.required' => 'El nombre del estudiante es obligatorio.',
            'nombres.max' => 'El nombre no debe exceder los 100 caracteres.',
            'id_curso.required' => 'Debe seleccionar un curso.',
            'id_curso.exists' => 'El curso seleccionado no es válido.',
            'id_tipo_beca.exists' => 'El tipo de beca seleccionado no es válido.',
        ];
    }
}

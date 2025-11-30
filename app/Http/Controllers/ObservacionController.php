<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Observaciones;
use App\Models\Plantel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ObservacionController extends Controller{
    public function index(Request $request){
        $query = Observaciones::with(['estudiante', 'curso.nivel', 'curso.paralelo', 'plantel']);
        if ($request->filled('search')){
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('estudiante', function ($qe) use ($search) {
                    $qe->where('nombres', 'like', "%$search%")
                    ->orWhere('apellido_p', 'like', "%$search%")
                    ->orWhere('apellido_m', 'like', "%$search%");
                })
                ->orWhereHas('plantel', function ($qp) use ($search) {
                    $qp->where('nombre', 'like', "%$search%");
                })
                ->orWhere('tipo', 'like', "%$search%")
                ->orWhere('descripcion', 'like', "%$search%")
                ->orWhere('fecha_evento', 'like', "%$search%");
            });
        }
        $observaciones = $query->latest()->paginate(15);
        $estudiantes = Estudiante::where('estado', true)->get();
        $plantel = Plantel::where('estado', true)->get();
        $cursos = Curso::with('nivel','paralelo')->where('estado', true)->get();
        $asignaturas = [
            'Arte',
            'Biología',
            'Ciencias Naturales',
            'Computación',
            'Educación Cívica',
            'Educación Física',
            'Filosofía',
            'Física',
            'Geografía',
            'Historia',
            'Inglés',
            'Lengua y Literatura',
            'Matemáticas',
            'Música',
            'Psicología',
            'Química',
            'Religión',
            'Fuera de materia',
        ];
        $tipos_observacion = array_keys(Observaciones::tipos());
        $miPlantel = Plantel::where('id_user', Auth::id())->first();

        return Inertia::render('Kardex/KardexIndex', [
            'observaciones' => $observaciones,
            'estudiantes' => $estudiantes,
            'plantel' => $plantel,
            'cursos' => $cursos,
            'asignaturas' => $asignaturas,
            'tipos_observacion' => $tipos_observacion,
            'mi_plantel' => $miPlantel,
            'filters' => $request->only('search'),
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'id_plantel' => 'required|exists:plantels,id',
            'id_estudiante' => 'required|exists:estudiantes,id',
            'tipo' => [
                'required',
                //Rule::in(array_keys(Observaciones::tipos()))
            ],
            'descripcion' => 'required|string|max:1000',
            'fecha_evento' => 'required|date|before_or_equal:today',
            'id_curso' => 'required|exists:cursos,id',
            'asignatura' => 'nullable|string|max:100',
        ]);

        Observaciones::create($request->only([
            'id_plantel',
            'id_estudiante',
            'tipo',
            'descripcion',
            'id_curso',
            'asignatura',
            'fecha_evento'
        ]));
        return back()->with('success', 'Observación registrada correctamente.');
    }
    public function update(Request $request, Observaciones $observacion){
        $this->autorizarUsuario($observacion);
        $request->validate([
            'id_plantel' => 'required|exists:plantels,id',
            'id_estudiante' => 'required|exists:estudiantes,id',
            'tipo' => [
                'required',
                Rule::in(array_keys(Observaciones::tipos()))
            ],
            'descripcion' => 'required|string|max:1000',
            'fecha_evento' => 'required|date|before_or_equal:today',
            'id_curso' => 'required|exists:cursos,id',
            'asignatura' => 'nullable|string|max:100',
        ]);
        $observacion->update($request->only([
            'id_plantel',
            'id_estudiante',
            'tipo',
            'descripcion',
            'id_curso',
            'asignatura',
            'fecha_evento'
        ]));
        return back()->with('success', 'Observación actualizada correctamente.');
    }
    public function OnOff($id){
        $obs = Observaciones::findOrFail($id);
        $this->autorizarUsuario($obs);
        $obs->estado = !$obs->estado;
        $obs->save();

        $mensaje = $obs->estado ? 'Observación habilitada nuevamente.' : 'Observación deshabilitada.';

        return back()->with($obs->estado ? 'success':'error' , $mensaje);
    }
    //Verificar que el usuario tenga permiso o sea admin
    function autorizarUsuario(Observaciones $observacion){
        if (!Auth::user()->hasRole('admin')) {
            $miPlantel = Auth::user()->plantel;
            if (!$miPlantel || $miPlantel->id !== $observacion->id_plantel) {
                abort(403, 'No tienes permiso para editar esta observación.');
            }
        }
    }
}

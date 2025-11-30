<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsistenciaDetalle;
use App\Models\PlantelAsignaturaCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller{
    public function index(){
        $user = Auth::user();
        $plantel = $user->plantel;

        if ($user->hasRole('admin')) {
            $cargaAcademica = PlantelAsignaturaCurso::with(['curso.nivel', 'curso.paralelo', 'asignatura', 'plantel'])
                ->where('estado', true)
                ->get();
        } else {
            $cargaAcademica = PlantelAsignaturaCurso::with(['curso', 'asignatura', 'plantel'])
                ->where('id_plantel', $plantel->id)
                ->where('estado', true)
                ->get();
        }

        return inertia('Kardex/Asistencias/AsistenciaIndex', [
            'carga_academica' => $cargaAcademica,
        ]);
    }

    public function store(Request $request){
        $user = Auth::user();
        $plantel = $user->plantel;
        $request->validate([
            'id_curso' => 'required|exists:cursos,id',
            'id_asignatura' => 'required|exists:asignaturas,id',
            'fecha' => 'required|date|before_or_equal:today',
            'estudiantes' => 'required|array',
            'estudiantes.*.id' => 'required|exists:estudiantes,id',
            'estudiantes.*.valor' => 'required|in:Presente,Ausente,Atraso,Justificado',
        ]);

        if (!$user->hasRole('admin')) {
            $permiso = PlantelAsignaturaCurso::where('id_plantel', $plantel->id)
                ->where('id_curso', $request->id_curso)
                ->where('id_asignatura', $request->id_asignatura)
                ->where('estado', true)
                ->exists();

            if (!$permiso) {
                return back()->withErrors(['Permiso denegado: no puedes tomar lista en esta asignatura.']);
            }
        }

        $asistencia = Asistencia::updateOrCreate(
            [
                'id_plantel' => $plantel->id,
                'id_curso' => $request->id_curso,
                'id_asignatura' => $request->id_asignatura,
                'fecha' => $request->fecha,
            ],
            [
                'observaciones' => $request->observaciones ?? null,
            ]
        );

        foreach ($request->estudiantes as $item) {
            AsistenciaDetalle::updateOrCreate(
                [
                    'id_asistencia' => $asistencia->id,
                    'id_estudiante' => $item['id'],
                ],
                [
                    'valor' => $item['valor'],
                    'observacion_individual' => $item['observacion_individual'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Asistencia registrada correctamente.');
    }
}

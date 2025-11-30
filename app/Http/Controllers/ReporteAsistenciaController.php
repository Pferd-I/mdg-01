<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsistenciaDetalle;
use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteAsistenciaController extends Controller{
    public function index(Request $request){

        $estudiantes = Estudiante::where('estado', true)
            ->with('curso')
            ->select('id', 'nombres', 'apellido_p', 'apellido_m', 'id_curso')
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'nombre_completo' => "{$e->apellido_p} {$e->apellido_m} {$e->nombres}",
                'curso' => $e->curso ? "{$e->curso->nro_grado}° {$e->curso->nivel->nombre_nivel}" : '—'
            ]);

        $cursos = Curso::where('estado', true)
            ->with('nivel', 'paralelo')
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'nombre' => "{$c->nro_grado}° {$c->nivel->nombre_nivel} \"{$c->paralelo->nombre_paralelo}\""
            ]);

        $asignaturas = Asignatura::where('estado', true)->get();

        $query = AsistenciaDetalle::with([
            'asistencia.curso.nivel',
            'asistencia.curso.paralelo',
            'asistencia.asignatura',
            'asistencia.plantel',
            'estudiante'
        ]);

        // Filtros
        if ($request->filled('estudiante_id')) {
            $query->where('id_estudiante', $request->estudiante_id);
        }

        if ($request->filled('curso_id')) {
            $query->whereHas('asistencia', fn($q) => $q->where('id_curso', $request->curso_id));
        }

        if ($request->filled('asignatura_id')) {
            $query->whereHas('asistencia', fn($q) => $q->where('id_asignatura', $request->asignatura_id));
        }

        if ($request->filled('fecha_desde')) {
            $query->whereHas('asistencia', fn($q) => $q->whereDate('fecha', '>=', $request->fecha_desde));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereHas('asistencia', fn($q) => $q->whereDate('fecha', '<=', $request->fecha_hasta));
        }

        if ($request->filled('valor')) {
            $query->where('valor', $request->valor);
        }
        $query->orderBy('created_at', 'desc');
        $detalles = $query->paginate(20);

        return Inertia::render('Reportes/Asistencia', [
            'detalles' => $detalles,
            'estudiantes' => $estudiantes,
            'cursos' => $cursos,
            'asignaturas' => $asignaturas,
            'filtros' => $request->only(['estudiante_id', 'curso_id', 'asignatura_id', 'fecha_desde', 'fecha_hasta', 'asistencia']),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use App\Models\AsistenciaDetalle;
use App\Models\Observaciones;
use App\Models\PlantelAsignaturaCurso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KardexSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $this->createObservacion(3, 1, 'Disciplina', 'El estudiante mostró un comportamiento ejemplar durante todo el semestre.',
            null, null, '2024-05-15');
        $this->createObservacion(4, 2, 'Académico', 'El estudiante ha mejorado significativamente en matemáticas.', 3, 'Matemáticas', '2024-06-10');
        $this->createObservacion(2, 3, 'Disciplina', 'El estudiante necesita mejorar su puntualidad.',
            null, null, '2024-04-20');
        $this->createObservacion(2, 4, 'Académico', 'El estudiante ha destacado en ciencias naturales.', 5, 'Ciencias Naturales', '2024-05-30');


        $this->createPlantelAsignaturaCurso(3, 1, 8);
        $this->createPlantelAsignaturaCurso(6, 9, 8);
        $this->createPlantelAsignaturaCurso(4, 2, 10);
        $this->createPlantelAsignaturaCurso(4, 11, 10);

        $this->createAsistencia(3, 8, 1, '2025-11-28', 'Asistencia del curso Pre-Kinder para la asignatura Arte');
        $this->createAsistencia(4, 10, 2, '2025-11-28', 'Asistencia del curso Pre-Kinder para la asignatura Biología');

        $this->createAsistenciaDetalle(1, 1, 'Presente');
    }
    private function createObservacion(int $id_plantel, int $id_estudiante, string $tipo, string $descripcion, ?int $id_curso, ?string $asignatura, string $fecha_evento): void{
        Observaciones::create([
            'id_plantel' => $id_plantel,
            'id_estudiante' => $id_estudiante,
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'id_curso' => $id_curso,
            'asignatura' => $asignatura,
            'fecha_evento' => $fecha_evento,
        ]);
    }

    private function createPlantelAsignaturaCurso(int $id_plantel, int $id_asignatura, int $id_curso){
        PlantelAsignaturaCurso::create([
            'id_plantel' => $id_plantel,
            'id_asignatura' => $id_asignatura,
            'id_curso' => $id_curso,
        ]);
    }
    private function createAsistencia(int $id_plantel, int $id_curso, int $id_asignatura, string $fecha, ?string $observaciones){
        Asistencia::create([
            'id_plantel' => $id_plantel,
            'id_curso' => $id_curso,
            'id_asignatura' => $id_asignatura,
            'fecha' => $fecha,
            'observaciones' => $observaciones,
        ]);
    }
    private function createAsistenciaDetalle(int $id_asistencia, int $id_estudiante, string $valor){
        AsistenciaDetalle::create([
            'id_asistencia' => $id_asistencia,
            'id_estudiante' => $id_estudiante,
            'valor' => $valor,
        ]);
    }
}

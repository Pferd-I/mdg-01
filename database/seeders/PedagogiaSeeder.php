<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class PedagogiaSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $this->CrearCurso('Pre-Kinder', 'Pre-Kinder', 1, 1, 2025);
        $this->CrearCurso('Kinder', 'Kinder', 1, 1, 2025);

        $this->CrearCurso('Primero', 1, 1, 2, 2025);
        $this->CrearCurso('Segundo', 2, 1, 2, 2025);
        $this->CrearCurso('Tercero', 3, 1, 2, 2025);
        $this->CrearCurso('Cuarto', 4, 1, 2, 2025);
        $this->CrearCurso('Quinto', 5, 1, 2, 2025);
        $this->CrearCurso('Sexto', 6, 1, 2, 2025);

        $this->CrearCurso('Primero', 1, 1, 3, 2025);
        $this->CrearCurso('Segundo', 2, 1, 3, 2025);
        $this->CrearCurso('Tercero', 3, 1, 3, 2025);
        $this->CrearCurso('Cuarto', 4, 1, 3, 2025);
        $this->CrearCurso('Quinto', 5, 1, 3, 2025);
        $this->CrearCurso('Sexto', 6, 1, 3, 2025);

        $this->createAsignatura('Arte', 'Asignatura de Arte');
        $this->createAsignatura('Biología', 'Asignatura de Biología');
        $this->createAsignatura('Ciencias Naturales', 'Asignatura de Ciencias Naturales');
        $this->createAsignatura('Ciencias Sociales', 'Asignatura de Ciencias Sociales');
        $this->createAsignatura('Educación Física', 'Asignatura de Educación Física');
        $this->createAsignatura('Filosofía', 'Asignatura de Filosofía');
        $this->createAsignatura('Física', 'Asignatura de Física');
        $this->createAsignatura('Informática', 'Asignatura de Informática');
        $this->createAsignatura('Inglés', 'Asignatura de Inglés');
        $this->createAsignatura('Lengua y Literatura', 'Asignatura de Lengua y Literatura');
        $this->createAsignatura('Matemáticas', 'Asignatura de Matemáticas');
        $this->createAsignatura('Música', 'Asignatura de Música');
        $this->createAsignatura('Química', 'Asignatura de Química');
        $this->createAsignatura('Religión', 'Asignatura de Religión');

    }
    private function CrearCurso(string $nom, string $nro, int $par, int $nivel, string $gestion){
        Curso::create([
            'grado' => $nom,
            'nro_grado' => $nro,
            'id_paralelo' => $par,
            'id_nivel' => $nivel,
            'gestion' =>$gestion,
        ]);
    }
    private function createAsignatura(string $nombre, string $descripcion){
        Asignatura::create([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
        ]);
    }
}

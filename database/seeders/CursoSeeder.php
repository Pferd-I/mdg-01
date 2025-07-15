<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder{
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
}

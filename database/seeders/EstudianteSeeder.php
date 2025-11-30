<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $this->crearEstudiante('6854772','2153151805','Durán', 'Ferrante', 'Pedro', 1, 2);
        $this->crearEstudiante('1254772','7753151805','Pérez', 'Soliz', 'André', 2, 10);
        $this->crearEstudiante('9854772','9953151805','Gómez', 'López', 'María', 1, 5);
        $this->crearEstudiante('4454772','1153151805','Ramírez', 'Torres', 'Luis', 3, 3);
        $this->crearEstudiante('2254772','3353151805','Vargas', 'Mendoza', 'Ana', 2, 8);
    }
    private function crearEstudiante(string $ci, string $rude, string $ap, string $am, string $nom, int $tipb, int $cur){
        Estudiante::create([
            'ci' => $ci,
            'rude' => $rude,
            'apellido_p' => $ap,
            'apellido_m' => $am,
            'nombres' => $nom,
            'id_tipo_beca' => $tipb,
            'id_curso' => $cur,
        ]);
    }
}

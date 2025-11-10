<?php

namespace Database\Seeders;

use App\Models\Contacto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ppff;
use App\Models\PpffEstudiante;
use Illuminate\Database\Seeder;

class PpffSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $this->createPpff('2355648', 'Paola Gutierrez');
        $this->createContacto(1, 'Casa', '3512664', 'Calle Del Olvido #132');
        $this->createContacto(1, 'Trabajo', '78945321', 'Av paraguá');
        $this->createPpff_Est(1, 1, 'Madre');
        $this->createPpff('7455648', 'Sandra Illanes');
        $this->createContacto(2, 'Casa', '64848864', 'Av del Amor #110');
        $this->createPpff_Est(2, 1, 'Tía');
        $this->createPpff('9412670', 'Carlos Guilme');
        $this->createContacto(3, 'Casa', '79912354', 'Av Beni #998');
        $this->createPpff_Est(3, 2, 'Tutor');
    }


    private function createPpff(string $ci, string $nom){
        Ppff::create([
            'cionit' => $ci,
            'nombre' => $nom,
        ]);
    }
    private function createContacto(int $id_ppff, string $tipo_contacto, string $telf, string $dir){
        Contacto::create([
            'id_ppff' => $id_ppff,
            'tipo_contacto' => $tipo_contacto,
            'nro_telf' => $telf,
            'direccion' => $dir,
        ]);
    }
    private function createPpff_Est( int $ppff, int $est,string $parentesco){
        PpffEstudiante::create([
            'id_estudiante' => $est,
            'id_ppff' => $ppff,
            'parentesco' => $parentesco,
        ]);
    }
}

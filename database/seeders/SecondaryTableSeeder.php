<?php

namespace Database\Seeders;


use App\Models\Paralelo;
use App\Models\Nivel;
use App\Models\TipoBeca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecondaryTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $this->createParalelo('A');

        $this->createNivel('Inicial');
        $this->createNivel('Primaria');
        $this->createNivel('Secundaria');

        $this->createTipoBeca('Sin beca','No hay descuento', 0);
        $this->createTipoBeca('Media beca','Descuento del 50%', 50);
        $this->createTipoBeca('Beca por tercer hermano','Beca del 100% por ser el tercer hermano inscrito', 100);
        $this->createTipoBeca('Beca por excelencia','Beca del 100% por excelencia académica', 100);
    }
    private function createParalelo(string $name){
        Paralelo::create([
            'nombre_paralelo' => $name,
        ]);
    }
    private function createNivel(string $name){
        Nivel::create([
            'nombre_nivel' => $name,
        ]);
    }
    private function createTipoBeca(string $name, string $desc, float $porc){
        TipoBeca::create([
            'nombre_tipo_beca' => $name,
            'descripcion' => $desc,
            'porcentaje' => $porc,
        ]);
    }
}

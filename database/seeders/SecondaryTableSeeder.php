<?php

namespace Database\Seeders;


use App\Models\Paralelo;
use App\Models\Nivel;
use App\Models\TipoBeca;
use App\Models\Mensualidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecondaryTableSeeder extends Seeder{
    /**
     *Tablas:
     *  Mensualidad
     *  Nivel
     *  Paralelo
     *  TipoBeca
     */
    public function run(): void{
        $this->createParalelo('A');

        $this->createNivel('Inicial');
        $this->createNivel('Primaria');
        $this->createNivel('Secundaria');

        $this->createTipoBeca('Sin beca','No hay descuento', 0);
        $this->createTipoBeca('Media beca','Descuento del 50%', 0.50);
        $this->createTipoBeca('Beca por tercer hermano','Beca del 100% por ser el tercer hermano inscrito', 1);
        $this->createTipoBeca('Beca por excelencia','Beca del 100% por excelencia académica', 1);

        $this->createMensualidad(2025, 1, 'Febrero', 500);
        $this->createMensualidad(2025, 2, 'Marzo', 500);
        $this->createMensualidad(2025, 3, 'Abril', 500);
        $this->createMensualidad(2025, 4, 'Mayo', 500);
        $this->createMensualidad(2025, 5, 'Junio', 500);
        $this->createMensualidad(2025, 6, 'Julio', 500);
        $this->createMensualidad(2025, 7, 'Agosto', 500);
        $this->createMensualidad(2025, 8, 'Septiembre', 500);
        $this->createMensualidad(2025, 9, 'Octubre', 500);
        $this->createMensualidad(2025, 10, 'Noviembre', 500);
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
    private function createTipoBeca(string $name, string $desc, float $coef){
        TipoBeca::create([
            'nombre_tipo_beca' => $name,
            'descripcion' => $desc,
            'coeficiente' => $coef,
        ]);
    }
    private function createMensualidad(int $gestion, int $nro_mes, string $nombre_mes, float $monto){
        Mensualidad::create([
            'nro_mes' => $nro_mes,
            'gestion' => $gestion,
            'nombre_mes' => $nombre_mes,
            'monto' => $monto,
        ]);
    }
}

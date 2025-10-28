<?php

namespace Database\Seeders;

use App\Models\Gestion;
use App\Models\Paralelo;
use App\Models\Nivel;
use App\Models\TipoBeca;
use App\Models\Mensualidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecondaryTableSeeder extends Seeder{
    /**
     *Tablas:
     *  Paralelo
     *  Nivel
     *  TipoBeca
     *  Gestión
     *  Mensualidad
     */
    public function run(): void{
        $this->createParalelo('A');

        $this->createNivel('Inicial', true);
        $this->createNivel('Primaria',true);
        $this->createNivel('Secundaria',true);
        $this->createNivel('Terciaria',false);

        $this->createTipoBeca('Sin beca','No hay descuento', 0);
        $this->createTipoBeca('Media beca','Descuento del 50%', 50);
        $this->createTipoBeca('Beca por tercer hermano','Beca del 100% por ser el tercer hermano inscrito', 100);
        $this->createTipoBeca('Beca por excelencia','Beca del 100% por excelencia académica', 100);

        $this->createGestion(2024,false);
        $this->createGestion(2025, true);

        $this->createMensualidad(1, 1, 'Febrero', 500);
        $this->createMensualidad(1, 2, 'Marzo', 500);
        $this->createMensualidad(1, 3, 'Abril', 500);
        $this->createMensualidad(1, 4, 'Mayo', 500);
        $this->createMensualidad(1, 5, 'Junio', 500);
        $this->createMensualidad(1, 6, 'Julio', 500);
        $this->createMensualidad(1, 7, 'Agosto', 500);
        $this->createMensualidad(1, 8, 'Septiembre', 500);
        $this->createMensualidad(1, 9, 'Octubre', 500);
        $this->createMensualidad(1, 10, 'Noviembre', 500);

        $this->createMensualidad(2, 1, 'Febrero', 500);
        $this->createMensualidad(2, 2, 'Marzo', 500);
        $this->createMensualidad(2, 3, 'Abril', 500);
        $this->createMensualidad(2, 4, 'Mayo', 500);
        $this->createMensualidad(2, 5, 'Junio', 500);
        $this->createMensualidad(2, 6, 'Julio', 500);
        $this->createMensualidad(2, 7, 'Agosto', 500);
        $this->createMensualidad(2, 8, 'Septiembre', 500);
        $this->createMensualidad(2, 9, 'Octubre', 500);
        $this->createMensualidad(2, 10, 'Noviembre', 500);
    }
    private function createGestion(int $gestion, bool $presente){
        Gestion::create([
            'gestion' => $gestion,
            'presente' => $presente,
        ]);
    }
    private function createParalelo(string $name){
        Paralelo::create([
            'nombre_paralelo' => $name,
        ]);
    }
    private function createNivel(string $name, bool $estado){
        Nivel::create([
            'nombre_nivel' => $name,
            'estado' => $estado,
        ]);
    }
    private function createTipoBeca(string $name, string $desc, float $dcto){
        TipoBeca::create([
            'nombre_tipo_beca' => $name,
            'descripcion' => $desc,
            'dcto' => $dcto,
        ]);
    }
    private function createMensualidad(int $id_gestion, int $nro_mes, string $nombre_mes, float $monto){
        Mensualidad::create([
            'nro_mes' => $nro_mes,
            'id_gestion' => $id_gestion,
            'nombre_mes' => $nombre_mes,
            'monto' => $monto,
        ]);
    }
}

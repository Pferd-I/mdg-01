<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        Post::create([
            'title' => 'Comunicado 01/2024',
            'subtitle' => 'Mensualidades febrero',
            'content' => 'Se comunica a los padres sajfel;fasjljdsafja sjj fl;asjdfhasdkfh sudahd khvas huds hu.',
            'tipo' => 1,
        ]);
        Post::create([
            'title' => 'Orden de Servicio 01/2024',
            'subtitle' => 'Entrega de Planes',
            'content' => 'Se comunica a los maestros de Secundaria que sldjfadfsa..asdflafbxlcijbggswmerwptw',
            'tipo' => 2,
        ]);
    }
}

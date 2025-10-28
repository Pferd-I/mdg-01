<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{

    public function run(): void{
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(SecondaryTableSeeder::class);

        $this->call(CursoSeeder::class);

        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);

        $this->call(EstudianteSeeder::class);
    }
}

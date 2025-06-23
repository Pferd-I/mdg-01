<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ppff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder{
    /**
     * Seeder para Tablas:
     *  Usuarios
     *  Clientes
     */
    public function run(): void{
        /*User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ])->assignRole('admin');*/
        $this->createUser('admin', 'admin', 'admin');
        $this->createUser('profeJuan', 'profe', 'profesor');
        $this->createUser('profeKarina', 'profe', 'profesor');
        $this->createUser('profeFreddy', 'profe', 'profesor');
        $this->createUser('profeRoxana', 'profe', 'profesor');
        $this->createUser('estFabiana', 'est', 'estudiante');
        $this->createUser('estVeronice', 'est', 'estudiante');
        $this->createUser('estNaomi', 'est', 'estudiante');
        $this->createUser('estTalita', 'est', 'estudiante');
        $this->createUser('estPaola', 'est', 'estudiante');
        $this->createUser('estMilca', 'est', 'estudiante');

        $this->createPpff('2355648', 'Paola Gutierrez', 'Calle del Olvido #1235');
    }
    private function createUser(string $name, string $pwd, string $role){
        User::create([
            'name' => $name,
            'email' => (string) $name .'@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make($pwd),
            'remember_token' => Str::random(10),
        ])->assignRole($role);
    }

    private function createPpff(string $ci, string $nom, string $dir){
        Ppff::create([
            'cionit' => $ci,
            'nombre' => $nom,
            'direccion' => $dir,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Plantel;
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
     *
     *  Plantel
     *  Cargos
     */
    public function run(): void{
        /*User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ])->assignRole('admin');*/
        $this->createCargo('Director', 'Director del plantel.');
        $this->createCargo('Administrativo', 'Personal Administrativo.');
        $this->createCargo('Docente', 'Profesor de materia.');

        $this->createUser('admin', 'admin', 'admin');
        $this->createPlantel('Superu', 1);

        $this->createUser('profeJuan', 'profe', 'profesor');
        $this->createPlantel('Juan Bernardo Aveldaño', 2);
        $this->assignCargoToPlantel(2, 3);

        $this->createUser('profeKarina', 'profe', 'profesor');
        $this->createPlantel('Karina Rodriguez', 3);
        $this->assignCargoToPlantel(3, 3);

        $this->createUser('profeFreddy', 'profe', 'profesor');
        $this->createPlantel('Freddy Gomez', 4);

        $this->createUser('profeRoxana', 'profe', 'profesor');
        $this->createPlantel('Roxana Martinez', 5);

        $this->createUser('estFabiana', 'est', 'estudiante');
        $this->createUser('estVeronice', 'est', 'estudiante');
        $this->createUser('estNaomi', 'est', 'estudiante');
        $this->createUser('estTalita', 'est', 'estudiante');
        $this->createUser('estPaola', 'est', 'estudiante');
        $this->createUser('estMilca', 'est', 'estudiante');
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
    private function createPlantel(string $nombre, int $id_user){
        Plantel::create([
            'nombre' => $nombre,
            'id_user' => $id_user,
        ]);
    }
    private function createCargo( string $nombre, ?string $descripcion = null){
        Cargo::create([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
        ]);
    }
    private function assignCargoToPlantel(int $id_plantel, int $id_cargo){
        $plantel = Plantel::findOrFail($id_plantel);
        $plantel->cargos()->attach($id_cargo, [
            'fecha_asignacion' => now(),
        ]);
    }
}

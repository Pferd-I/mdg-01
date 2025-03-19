<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $this->createAndAssign('Editar Posts', 'admin');
        $this->createAndAssign('Editar Usuarios', 'admin');
    }
    private function createAndAssign(string $Permission, string $Role){
        Permission::create([
            'name' => $Permission
        ])->assignRole($Role);
    }
    private function createPermission(string $Permission){
        Permission::create([
            'name' => $Permission
        ]);
    }
}

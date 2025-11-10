<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar al RoleSeeder creado
        $this->call([
            RoleSeeder::class,
        ]);

        // Crear nuevo usuario de prueba
        User::factory()->create([
            'name' => 'Usuario Prueba',
            'email' => 'Prueba1@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}

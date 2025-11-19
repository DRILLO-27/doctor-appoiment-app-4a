<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear nuevo usuario de prueba
        User::factory()->create([
            'name' => 'Usuario Prueba',
            'email' => 'Prueba1@gmail.com',
            'password' => bcrypt('123456'),
            'id_number' => '1234567890', // Asegúrate de que este campo exista en tu modelo User
            'phone' => '1234567890', // Asegúrate de que este campo exista en tu modelo User
            'address' => '123 Main St', // Aseg
        ])->assignRole('Doctor'); // Asignar rol de Paciente
    }
}

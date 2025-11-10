<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir roles del sistema
        $roles = [
            'Paciente',
            'Doctor',
            'Recepcionista',
            'Administrador',
        ];

        // Crear roles asegurando que incluyan guard_name
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web', // 🔒 evita el error de 'guard_name'
            ]);
        }

        // (Opcional) Definir permisos base
        $permissions = [
            'ver citas',
            'crear citas',
            'editar citas',
            'eliminar citas',
            'ver pacientes',
            'registrar pacientes',
            'editar pacientes',
            'eliminar pacientes',
        ];

        // Crear permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Asignar permisos según el rol (ajústalo a tu lógica)
        $rolePaciente = Role::where('name', 'Paciente')->first();
        $roleDoctor = Role::where('name', 'Doctor')->first();
        $roleRecepcionista = Role::where('name', 'Recepcionista')->first();
        $roleAdmin = Role::where('name', 'Administrador')->first();

        // Asignar permisos
        $rolePaciente->givePermissionTo(['ver citas', 'crear citas']);
        $roleDoctor->givePermissionTo(['ver citas', 'editar citas']);
        $roleRecepcionista->givePermissionTo([
            'ver citas', 'crear citas', 'editar citas', 'eliminar citas',
            'ver pacientes', 'registrar pacientes', 'editar pacientes'
        ]);
        $roleAdmin->givePermissionTo(Permission::all()); // todos los permisos 🔥
    }
}

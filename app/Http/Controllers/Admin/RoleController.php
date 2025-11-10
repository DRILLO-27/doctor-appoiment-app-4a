<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar que se cree bien
        $request->validate([
            'name' => 'required|unique:roles,name']);

        //si pasa la validadion, crear el rol
        Role::create([
    'name' => $request->name,
    'guard_name' => 'web', // 🔒 evita el error
]);
   

        //variable de un solo uso para alerta
        session()->flash('swal',
         [
            'icon' => 'success',
            'title' => 'Role creado correctamente',
            'text' => 'El rol ha sido creado exitosamente'
         ]);

        //Redirecionara a la tabla principal de roles
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //Restringir la accion para los primeros 4 roles 
         if ($role->id <= 4) {
            session()->flash('swal',
             [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes editar este role'
             ]);
            return redirect()->route('admin.roles.index');
        }
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //validar que se cree bien
        $request->validate([
        'name' => 'required|unique:roles,name,' . $role->id]);

        //si el campo no cambio, no actualices
        if ($role->name === $request->name) {
             session()->flash('swal',
         [
            'icon' => 'info',
            'title' => 'sin cambios',
            'text' => 'no se detectaron modificaciones'
         ]);
            return redirect()->route('admin.roles.edit',  $role);
        }

        //si pasa la validadion, crear el rol
        $role->update(['name' => $request->name]);

        //variable de un solo uso para alerta
        session()->flash('swal',
         [
            'icon' => 'success',
            'title' => 'Role creado correctamente',
            'text' => 'El rol ha sido actualizado exitosamente'
         ]);

        //Redirecionara a la tabla principal de roles
        return redirect()->route('admin.roles.index',  $role);
    } 

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Role $role)
{
    // 🛑 Evitar eliminación de los roles principales del sistema
    $rolesProtegidos = ['Paciente', 'Doctor', 'Recepcionista', 'Administrador'];

    if (in_array($role->name, $rolesProtegidos)) {
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'Acción no permitida',
            'text' => 'No puedes eliminar un rol principal del sistema'
        ]);
        return redirect()->route('admin.roles.index');
    }

    // 🧩 Verificar si el rol está asignado a algún usuario
    $hasUsers = \DB::table('model_has_roles')
        ->where('role_id', $role->id)
        ->exists();

    if ($hasUsers) {
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'No se puede eliminar el rol',
            'text' => 'El rol tiene usuarios asociados y no puede ser eliminado'
        ]);
        return redirect()->route('admin.roles.index');
    }

    // ✅ Si no está protegido ni asignado, eliminar el rol
    $role->delete();

    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Rol eliminado correctamente',
        'text' => 'El rol ha sido eliminado exitosamente'
    ]);

    return redirect()->route('admin.roles.index');
}


}
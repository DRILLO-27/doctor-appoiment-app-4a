<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array',
            'roles.0' => 'exists:roles,id',
            'id_number' => 'nullable|string|max:50|regex:/^[A-Za-z0-9\-]+$/|unique:users,id_number',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $role = Role::findById($request->roles[0]);
        $user->syncRoles($role->name);

        // ✅ SWEETALERT CREATE
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado',
            'text' => 'El usuario ha sido creado correctamente.',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'roles' => 'required|array',
            'roles.0' => 'exists:roles,id',
            'id_number' => "nullable|string|max:50|regex:/^[A-Za-z0-9\-]+$/|unique:users,id_number,$id",
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);

            $user->password = bcrypt($request->password);
            $user->save();
        }

        $role = Role::findById($request->roles[0]);
        $user->syncRoles($role->name);

        // ✅ SWEETALERT UPDATE
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado',
            'text' => 'El usuario ha sido actualizado correctamente.',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->syncRoles([]);
        $user->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario eliminado',
            'text' => 'El usuario ha sido eliminado correctamente.',
        ]);

        return redirect()->route('admin.users.index');
    }
}

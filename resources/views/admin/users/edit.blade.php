<x-admin-layout title="Editar Usuario | Meditime"
                :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Usuarios', 'href' => route('admin.users.index')],
    ['name' => 'Editar'],
]">

    <x-wire-card>
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <x-wire-input
                label="Nombre"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
            />

            {{-- Email --}}
            <x-wire-input
                label="Correo Electrónico"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                inputmode="email"
            />

            {{-- Passwords --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input
                    label="Contraseña (opcional)"
                    name="password"
                    type="password"
                    placeholder="Dejar vacío para no cambiar"
                />

                <x-wire-input
                    label="Confirmar Contraseña"
                    name="password_confirmation"
                    type="password"
                />
            </div>

            <p class="text-sm text-gray-500">
                Solo complete la contraseña si desea cambiarla
            </p>

            {{-- ID + Phone --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input
                    label="Número de Identificación"
                    name="id_number"
                    type="text"
                    value="{{ old('id_number', $user->id_number) }}"
                    required
                    inputmode="numeric"
                />

                <x-wire-input
                    label="Teléfono"
                    name="phone"
                    type="text"
                    value="{{ old('phone', $user->phone) }}"
                    inputmode="tel"
                />
            </div>

            {{-- Dirección --}}
            <x-wire-input
                label="Dirección"
                name="address"
                type="text"
                value="{{ old('address', $user->address) }}"
            />

            {{-- Rol (Spatie) --}}
            <x-wire-native-select
                label="Rol"
                name="roles[]"
                required>
                <option value="">Seleccione un rol</option>

                @foreach ($roles as $role)
                    <option
                        value="{{ $role->id }}"
                        @selected(
                            old('roles.0', $user->roles->first()?->id) == $role->id
                        )
                    >
                        {{ $role->name }}
                    </option>
                @endforeach
            </x-wire-native-select>

            <p class="text-sm text-gray-500">
                Define los permisos y accesos del usuario
            </p>

            <div class="flex justify-end gap-2">
                <x-wire-button href="{{ route('admin.users.index') }}" gray>
                    Cancelar
                </x-wire-button>

                <x-wire-button type="submit" blue>
                    Actualizar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>

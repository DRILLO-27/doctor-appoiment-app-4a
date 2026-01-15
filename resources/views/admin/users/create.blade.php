<x-admin-layout title="Nuevo Usuario | Meditime"
:breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Usuarios', 'href' => route('admin.users.index')],
    ['name' => 'Nuevo'],
]">

    <x-wire-card>
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nombre --}}
            <x-wire-input
                label="Nombre"
                name="name"
                type="text"
                placeholder="Ingrese el nombre del usuario"
                value="{{ old('name') }}"
                required
            />

            {{-- Email --}}
            <x-wire-input
                label="Correo Electrónico"
                name="email"
                type="email"
                placeholder="Ingrese el correo electrónico del usuario"
                value="{{ old('email') }}"
                required
                inputmode="email"
            />

            {{-- Passwords --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input
                    label="Contraseña"
                    name="password"
                    type="password"
                    placeholder="Ingrese la contraseña"
                    required
                />

                <x-wire-input
                    label="Confirmar Contraseña"
                    name="password_confirmation"
                    type="password"
                    placeholder="Confirme la contraseña"
                    required
                />
            </div>

            {{-- ID + Phone --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input
                    label="Número de Identificación"
                    name="id_number"
                    type="text"
                    placeholder="Ingrese el número de identificación"
                    value="{{ old('id_number') }}"
                    required
                    inputmode="numeric"
                />

                <x-wire-input
                    label="Teléfono"
                    name="phone"
                    type="text"
                    placeholder="Ingrese el teléfono"
                    value="{{ old('phone') }}"
                    inputmode="tel"
                />
            </div>

            {{-- Dirección --}}
            <x-wire-input
                label="Dirección"
                name="address"
                type="text"
                placeholder="Ingrese la dirección"
                value="{{ old('address') }}"
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
                        @selected(old('roles.0') == $role->id)
                    >
                        {{ $role->name }}
                    </option>
                @endforeach
            </x-wire-native-select>

            <p class="text-sm text-gray-500">
                Define los permisos y accesos del usuario
            </p>

            <div class="flex justify-end">
                <x-wire-button type="submit" blue>
                    Guardar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>

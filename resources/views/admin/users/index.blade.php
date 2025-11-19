<x-admin-layout title="Usuarios | Meditime"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
    ]
]">

    {{-- 🔹 Botón principal --}}
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.users.create') }}">
            <i class="fa-solid fa-user-plus"></i> Nuevo Usuario
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.user-table')

</x-admin-layout>

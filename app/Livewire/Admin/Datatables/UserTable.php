<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;  // 👈 IMPORT CORRECTO

class UserTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return User::query()->with('roles');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Nombre", "name")->sortable(),
            Column::make("Email", "email")->sortable(),
            Column::make("Número de Id", "id_number")->sortable(),
            Column::make("Teléfono", "phone")->sortable(),

            Column::make("Rol", "roles")
                ->label(fn($row) => $row->roles->first()?->name ?? 'Sin Rol'),

            Column::make("Acciones")
                ->label(fn($row) => view('admin.users.actions', ['user' => $row])),
        ];
    }
}

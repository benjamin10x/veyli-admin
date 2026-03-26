<?php

namespace App\Livewire\Admin;

use App\Services\RolesApiService;
use App\Services\UsersApiService;

class UsersPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return UsersApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Gestión de Usuarios',
            'subtitle' => 'Administra accesos internos y permisos.',
            'create_label' => 'Registrar usuario',
            'search_placeholder' => 'Buscar nombre o correo...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nombre', 'type' => 'text', 'nullable' => false],
            ['key' => 'email', 'label' => 'Correo', 'type' => 'email', 'nullable' => false],
            ['key' => 'password', 'label' => 'Contraseña', 'type' => 'password', 'nullable' => true],
            ['key' => 'role_id', 'label' => 'Rol', 'type' => 'select', 'nullable' => false],
            ['key' => 'state', 'label' => 'Estado', 'type' => 'select', 'default' => 'active', 'nullable' => false],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Nombre', 'key' => 'name'],
            ['label' => 'Correo', 'key' => 'email'],
            ['label' => 'Rol', 'key' => 'role.name'],
            ['label' => 'Estado', 'key' => 'state', 'type' => 'badge'],
            ['label' => 'Registro', 'key' => 'created_at', 'type' => 'date'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.name' => ['required', 'string', 'max:150'],
            'form.email' => ['required', 'email'],
            'form.password' => [$this->editing ? 'nullable' : 'required', 'string', 'min:8'],
            'form.role_id' => ['required', 'integer'],
            'form.state' => ['required', 'in:active,inactive'],
        ];
    }

    protected function quickToggleEnabled(): bool
    {
        return true;
    }

    protected function statusTabs(): array
    {
        return ['all' => 'Todos', 'active' => 'Activos', 'inactive' => 'Inactivos'];
    }

    protected function selectOptions(): array
    {
        $roles = data_get(app(RolesApiService::class)->list(['page_size' => 100]), 'data.items', []);

        return [
            'role_id' => collect($roles)->map(fn ($role) => [
                'value' => data_get($role, 'id'),
                'label' => data_get($role, 'name'),
            ])->values()->all(),
            'state' => [
                ['value' => 'active', 'label' => 'Activo'],
                ['value' => 'inactive', 'label' => 'Inactivo'],
            ],
        ];
    }
}

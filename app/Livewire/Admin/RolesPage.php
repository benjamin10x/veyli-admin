<?php

namespace App\Livewire\Admin;

use App\Services\RolesApiService;

class RolesPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return RolesApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Gestión de Roles',
            'subtitle' => 'Administra los roles y sus estados operativos.',
            'create_label' => 'Crear rol',
            'search_placeholder' => 'Buscar rol o descripción...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nombre', 'type' => 'text', 'nullable' => false],
            ['key' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'nullable' => true, 'full_width' => true],
            [
                'key' => 'state',
                'label' => 'Estado del rol',
                'type' => 'switch',
                'default' => true,
                'checked_value' => 'active',
                'unchecked_value' => 'inactive',
                'switch_label' => 'Rol activo',
                'nullable' => false,
                'wrapper_class' => 'role-state-field',
            ],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Nombre', 'key' => 'name'],
            ['label' => 'Descripción', 'key' => 'description'],
            ['label' => 'Estado', 'key' => 'state', 'type' => 'badge'],
            ['label' => 'Actualizado', 'key' => 'updated_at', 'type' => 'datetime'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.name' => ['required', 'string', 'min:2', 'max:50'],
            'form.description' => ['nullable', 'string', 'max:255'],
            'form.state' => ['required', 'boolean'],
        ];
    }

    protected function quickToggleEnabled(): bool
    {
        return false;
    }

    protected function statusTabs(): array
    {
        return ['all' => 'Todos', 'active' => 'Activos', 'inactive' => 'Inactivos'];
    }
}

<?php

namespace App\Livewire\Admin;

use App\Services\PackageStatusesApiService;

class PackageStatusesPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return PackageStatusesApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Estados de Paquete',
            'subtitle' => 'Configura el catálogo oficial de estados del envío.',
            'create_label' => 'Nuevo estado',
            'search_placeholder' => 'Buscar estado...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nombre', 'type' => 'text', 'nullable' => false],
            ['key' => 'color', 'label' => 'Color', 'type' => 'color', 'default' => '#9ca3af', 'nullable' => false],
            ['key' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'nullable' => true],
            ['key' => 'state', 'label' => 'Estado', 'type' => 'select', 'default' => 'active', 'nullable' => false],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Nombre', 'key' => 'name'],
            ['label' => 'Color', 'key' => 'color', 'type' => 'color'],
            ['label' => 'Descripción', 'key' => 'description'],
            ['label' => 'Estado', 'key' => 'state', 'type' => 'badge'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.name' => ['required', 'string', 'min:2', 'max:100'],
            'form.color' => ['required', 'string', 'min:4', 'max:20'],
            'form.description' => ['nullable', 'string', 'max:255'],
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
        return [
            'state' => [
                ['value' => 'active', 'label' => 'Activo'],
                ['value' => 'inactive', 'label' => 'Inactivo'],
            ],
        ];
    }
}

<?php

namespace App\Livewire\Admin;

use App\Services\VehiclesApiService;

class VehiclesPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return VehiclesApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Vehículos',
            'subtitle' => 'Controla flota, capacidad y disponibilidad operativa.',
            'create_label' => 'Registrar vehículo',
            'search_placeholder' => 'Buscar placas o tipo...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'plates', 'label' => 'Placas', 'type' => 'text', 'nullable' => false],
            ['key' => 'vehicle_type', 'label' => 'Tipo', 'type' => 'select', 'default' => 'Camioneta', 'nullable' => false],
            ['key' => 'capacity', 'label' => 'Capacidad', 'type' => 'number', 'nullable' => false],
            ['key' => 'operational_status', 'label' => 'Estado operativo', 'type' => 'select', 'default' => 'available', 'nullable' => false],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Placas', 'key' => 'plates'],
            ['label' => 'Tipo', 'key' => 'vehicle_type'],
            ['label' => 'Capacidad', 'key' => 'capacity', 'type' => 'number'],
            ['label' => 'Estado', 'key' => 'operational_status', 'type' => 'badge'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.plates' => ['required', 'string', 'max:20'],
            'form.vehicle_type' => ['required', 'string', 'max:80'],
            'form.capacity' => ['required', 'numeric', 'min:1'],
            'form.operational_status' => ['required', 'in:available,active,maintenance,inactive'],
        ];
    }

    protected function statusTabs(): array
    {
        return ['all' => 'Todos', 'available' => 'Disponibles', 'active' => 'Activos', 'maintenance' => 'Mantenimiento', 'inactive' => 'Inactivos'];
    }

    protected function selectOptions(): array
    {
        return [
            'vehicle_type' => [
                ['value' => 'Camioneta', 'label' => 'Camioneta'],
                ['value' => 'Van', 'label' => 'Van'],
                ['value' => 'Motocicleta', 'label' => 'Motocicleta'],
                ['value' => 'Pickup', 'label' => 'Pickup'],
            ],
            'operational_status' => [
                ['value' => 'available', 'label' => 'Disponible'],
                ['value' => 'active', 'label' => 'Activo'],
                ['value' => 'maintenance', 'label' => 'Mantenimiento'],
                ['value' => 'inactive', 'label' => 'Inactivo'],
            ],
        ];
    }
}

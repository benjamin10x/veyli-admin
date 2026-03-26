<?php

namespace App\Livewire\Admin;

use App\Services\AssignmentsApiService;
use App\Services\DriversApiService;
use App\Services\PackagesApiService;
use App\Services\RoutesApiService;
use App\Services\VehiclesApiService;

class AssignmentsPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return AssignmentsApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Asignaciones',
            'subtitle' => 'Relaciona paquetes con ruta, conductor y vehículo.',
            'create_label' => 'Nueva asignación',
            'search_placeholder' => 'Buscar tracking, ruta o conductor...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'package_id', 'label' => 'Paquete', 'type' => 'select', 'nullable' => false, 'record_key' => 'package.id', 'empty_message' => 'No hay paquetes asignables. Revisa que no esten entregados o cancelados.'],
            ['key' => 'route_id', 'label' => 'Ruta', 'type' => 'select', 'nullable' => false, 'record_key' => 'route.id', 'empty_message' => 'No hay rutas disponibles. Deben estar activas o programadas.'],
            ['key' => 'vehicle_id', 'label' => 'Vehículo', 'type' => 'select', 'nullable' => false, 'record_key' => 'vehicle.id', 'empty_message' => 'No hay vehiculos disponibles. Deben estar activos o disponibles.'],
            ['key' => 'driver_id', 'label' => 'Conductor', 'type' => 'select', 'nullable' => false, 'record_key' => 'driver.id', 'empty_message' => 'No hay conductores activos disponibles para asignar.'],
            ['key' => 'notes', 'label' => 'Observaciones', 'type' => 'textarea', 'nullable' => true],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Tracking', 'key' => 'package.tracking_code'],
            ['label' => 'Ruta', 'key' => 'route.zone'],
            ['label' => 'Vehículo', 'key' => 'vehicle.plates'],
            ['label' => 'Conductor', 'key' => 'driver.name'],
            ['label' => 'Asignado', 'key' => 'assigned_at', 'type' => 'datetime'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.package_id' => ['required', 'integer'],
            'form.route_id' => ['required', 'integer'],
            'form.vehicle_id' => ['required', 'integer'],
            'form.driver_id' => ['required', 'integer'],
            'form.notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected function selectOptions(): array
    {
        $packages = data_get(app(PackagesApiService::class)->list(['page_size' => 100]), 'data.items', []);
        $routes = data_get(app(RoutesApiService::class)->list(['page_size' => 100]), 'data.items', []);
        $vehicles = data_get(app(VehiclesApiService::class)->list(['page_size' => 100]), 'data.items', []);
        $drivers = data_get(app(DriversApiService::class)->list(['page_size' => 100]), 'data.items', []);
        $currentPackageId = (int) ($this->form['package_id'] ?? 0);
        $currentRouteId = (int) ($this->form['route_id'] ?? 0);
        $currentVehicleId = (int) ($this->form['vehicle_id'] ?? 0);
        $currentDriverId = (int) ($this->form['driver_id'] ?? 0);

        return [
            'package_id' => collect($packages)
                ->filter(fn ($item) => data_get($item, 'id') === $currentPackageId || ! in_array(data_get($item, 'status.name'), ['Entregado', 'Cancelado'], true))
                ->map(fn ($item) => [
                    'value' => data_get($item, 'id'),
                    'label' => data_get($item, 'tracking_code').' · '.data_get($item, 'status.name', 'Sin estado'),
                ])->values()->all(),
            'route_id' => collect($routes)
                ->filter(fn ($item) => data_get($item, 'id') === $currentRouteId || in_array(data_get($item, 'route_status'), ['scheduled', 'active'], true))
                ->map(fn ($item) => [
                    'value' => data_get($item, 'id'),
                    'label' => data_get($item, 'zone').' · '.data_get($item, 'route_status'),
                ])->values()->all(),
            'vehicle_id' => collect($vehicles)
                ->filter(fn ($item) => data_get($item, 'id') === $currentVehicleId || in_array(data_get($item, 'operational_status'), ['available', 'active'], true))
                ->map(fn ($item) => [
                    'value' => data_get($item, 'id'),
                    'label' => data_get($item, 'plates').' · '.data_get($item, 'operational_status'),
                ])->values()->all(),
            'driver_id' => collect($drivers)
                ->filter(fn ($item) => data_get($item, 'id') === $currentDriverId || data_get($item, 'employment_status') === 'active')
                ->map(fn ($item) => [
                    'value' => data_get($item, 'id'),
                    'label' => data_get($item, 'name').' · '.data_get($item, 'employment_status'),
                ])->values()->all(),
        ];
    }
}

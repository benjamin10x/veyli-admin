<?php

namespace App\Livewire\Admin;

use App\Services\RoutesApiService;

class RoutesPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return RoutesApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Rutas',
            'subtitle' => 'Gestiona zonas de salida y tiempos estimados.',
            'create_label' => 'Crear ruta',
            'search_placeholder' => 'Buscar zona...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'zone', 'label' => 'Zona', 'type' => 'text', 'nullable' => false],
            ['key' => 'departure_date', 'label' => 'Fecha de salida', 'type' => 'date', 'nullable' => false],
            ['key' => 'departure_time', 'label' => 'Hora de salida', 'type' => 'time', 'nullable' => false],
            ['key' => 'estimated_time_minutes', 'label' => 'Tiempo estimado (min)', 'type' => 'number', 'nullable' => false],
            ['key' => 'route_status', 'label' => 'Estado ruta', 'type' => 'select', 'default' => 'scheduled', 'nullable' => false],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Zona', 'key' => 'zone'],
            ['label' => 'Fecha', 'key' => 'departure_date', 'type' => 'date'],
            ['label' => 'Hora', 'key' => 'departure_time'],
            ['label' => 'Tiempo', 'key' => 'estimated_time_minutes'],
            ['label' => 'Estado', 'key' => 'route_status', 'type' => 'badge'],
        ];
    }

    protected function rules(): array
    {
        $departureDateRules = ['required', 'date'];

        if (! $this->editing) {
            $departureDateRules[] = 'after_or_equal:today';
        }

        return [
            'form.zone' => ['required', 'string', 'min:2', 'max:120'],
            'form.departure_date' => $departureDateRules,
            'form.departure_time' => ['required', 'date_format:H:i'],
            'form.estimated_time_minutes' => ['required', 'numeric', 'min:1'],
            'form.route_status' => ['required', 'in:scheduled,active,completed,inactive'],
        ];
    }

    protected function statusTabs(): array
    {
        return ['all' => 'Todas', 'scheduled' => 'Programadas', 'active' => 'Activas', 'completed' => 'Completadas', 'inactive' => 'Inactivas'];
    }

    protected function selectOptions(): array
    {
        return [
            'route_status' => [
                ['value' => 'scheduled', 'label' => 'Programada'],
                ['value' => 'active', 'label' => 'Activa'],
                ['value' => 'completed', 'label' => 'Completada'],
                ['value' => 'inactive', 'label' => 'Inactiva'],
            ],
        ];
    }
}

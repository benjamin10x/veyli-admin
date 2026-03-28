<?php

namespace App\Livewire\Admin;

use App\Services\DriversApiService;

class DriversPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return DriversApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Conductores',
            'subtitle' => 'Administra disponibilidad y datos laborales de los conductores.',
            'create_label' => 'Registrar conductor',
            'search_placeholder' => 'Buscar identificación, nombre o licencia...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'identification', 'label' => 'Identificación', 'type' => 'text', 'nullable' => false],
            ['key' => 'name', 'label' => 'Nombre', 'type' => 'text', 'nullable' => false],
            ['key' => 'phone', 'label' => 'Teléfono', 'type' => 'text', 'nullable' => true],
            ['key' => 'shift', 'label' => 'Turno', 'type' => 'select', 'default' => 'Matutino', 'nullable' => false],
            ['key' => 'license_number', 'label' => 'Licencia', 'type' => 'text', 'nullable' => false],
            ['key' => 'hired_at', 'label' => 'Fecha de contratación', 'type' => 'date', 'nullable' => true],
            ['key' => 'employment_status', 'label' => 'Estado laboral', 'type' => 'select', 'default' => 'active', 'nullable' => false],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Identificación', 'key' => 'identification'],
            ['label' => 'Nombre', 'key' => 'name'],
            ['label' => 'Teléfono', 'key' => 'phone'],
            ['label' => 'Turno', 'key' => 'shift'],
            ['label' => 'Estado', 'key' => 'employment_status', 'type' => 'badge'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.identification' => ['required', 'string', 'min:3', 'max:50'],
            'form.name' => ['required', 'string', 'min:2', 'max:150'],
            'form.phone' => ['nullable', 'string', 'max:30'],
            'form.shift' => ['required', 'in:Matutino,Vespertino,Nocturno,Mixto'],
            'form.license_number' => ['required', 'string', 'min:3', 'max:100'],
            'form.hired_at' => ['nullable', 'date', 'before_or_equal:today'],
            'form.employment_status' => ['required', 'in:active,inactive,on_leave'],
        ];
    }

    protected function statusTabs(): array
    {
        return ['all' => 'Todos', 'active' => 'Activos', 'inactive' => 'Inactivos', 'on_leave' => 'Licencia'];
    }

    protected function selectOptions(): array
    {
        return [
            'shift' => [
                ['value' => 'Matutino', 'label' => 'Matutino'],
                ['value' => 'Vespertino', 'label' => 'Vespertino'],
                ['value' => 'Nocturno', 'label' => 'Nocturno'],
                ['value' => 'Mixto', 'label' => 'Mixto'],
            ],
            'employment_status' => [
                ['value' => 'active', 'label' => 'Activo'],
                ['value' => 'inactive', 'label' => 'Inactivo'],
                ['value' => 'on_leave', 'label' => 'Licencia'],
            ],
        ];
    }
}

<?php

namespace App\Livewire\Admin;

use App\Services\ClientsApiService;

class ClientsPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return ClientsApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Clientes',
            'subtitle' => 'Gestiona la base de clientes y sus datos de acceso.',
            'create_label' => 'Registrar cliente',
            'search_placeholder' => 'Buscar cliente, correo o teléfono...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'first_name', 'label' => 'Nombre', 'type' => 'text', 'nullable' => false],
            ['key' => 'last_name', 'label' => 'Apellidos', 'type' => 'text', 'nullable' => false],
            ['key' => 'email', 'label' => 'Correo', 'type' => 'email', 'nullable' => false],
            ['key' => 'phone', 'label' => 'Teléfono', 'type' => 'text', 'nullable' => true],
            ['key' => 'address', 'label' => 'Dirección', 'type' => 'textarea', 'nullable' => true],
            ['key' => 'password', 'label' => 'Contraseña temporal', 'type' => 'password', 'nullable' => true, 'create_only' => true],
            ['key' => 'state', 'label' => 'Estado', 'type' => 'select', 'default' => 'active', 'nullable' => false],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Nombre', 'key' => 'first_name'],
            ['label' => 'Apellidos', 'key' => 'last_name'],
            ['label' => 'Correo', 'key' => 'email'],
            ['label' => 'Teléfono', 'key' => 'phone'],
            ['label' => 'Estado', 'key' => 'state', 'type' => 'badge'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.first_name' => ['required', 'string', 'max:100'],
            'form.last_name' => ['required', 'string', 'max:100'],
            'form.email' => ['required', 'email'],
            'form.phone' => ['nullable', 'string', 'max:30'],
            'form.address' => ['nullable', 'string', 'max:255'],
            'form.password' => [$this->editing ? 'nullable' : 'required', 'string', 'min:8'],
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

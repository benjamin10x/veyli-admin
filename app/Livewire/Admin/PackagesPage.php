<?php

namespace App\Livewire\Admin;

use App\Services\ClientsApiService;
use App\Services\PackageStatusesApiService;
use App\Services\PackagesApiService;

class PackagesPage extends BaseResourcePage
{
    protected function serviceClass(): string
    {
        return PackagesApiService::class;
    }

    protected function pageMeta(): array
    {
        return [
            'title' => 'Envíos / Paquetes',
            'subtitle' => 'Controla el registro y estado operativo de cada envío.',
            'create_label' => 'Registrar envío',
            'search_placeholder' => 'Buscar tracking, cliente o destino...',
        ];
    }

    protected function fields(): array
    {
        return [
            ['key' => 'client_id', 'label' => 'Cliente', 'type' => 'select', 'nullable' => false, 'record_key' => 'client.id'],
            ['key' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'nullable' => false],
            ['key' => 'weight', 'label' => 'Peso', 'type' => 'number', 'nullable' => false],
            ['key' => 'volume', 'label' => 'Volumen', 'type' => 'number', 'nullable' => true],
            ['key' => 'package_type', 'label' => 'Tipo paquete', 'type' => 'text', 'nullable' => false],
            ['key' => 'origin_address', 'label' => 'Origen', 'type' => 'text', 'nullable' => false],
            ['key' => 'destination_address', 'label' => 'Destino', 'type' => 'text', 'nullable' => false],
            ['key' => 'estimated_delivery_at', 'label' => 'Entrega estimada', 'type' => 'datetime-local', 'nullable' => true],
            ['key' => 'package_status_id', 'label' => 'Estado', 'type' => 'select', 'nullable' => true, 'record_key' => 'status.id'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['label' => 'Tracking', 'key' => 'tracking_code'],
            ['label' => 'Cliente', 'key' => 'client.email'],
            ['label' => 'Destino', 'key' => 'destination_address'],
            ['label' => 'Tipo', 'key' => 'package_type'],
            ['label' => 'Estado', 'key' => 'status.name', 'type' => 'badge', 'color_key' => 'status.color'],
        ];
    }

    protected function rules(): array
    {
        return [
            'form.client_id' => ['required', 'integer'],
            'form.description' => ['required', 'string', 'max:255'],
            'form.weight' => ['required', 'numeric', 'min:0.1'],
            'form.volume' => ['nullable', 'numeric', 'min:0.01'],
            'form.package_type' => ['required', 'string', 'max:100'],
            'form.origin_address' => ['required', 'string', 'max:255'],
            'form.destination_address' => ['required', 'string', 'max:255'],
            'form.estimated_delivery_at' => ['nullable'],
            'form.package_status_id' => ['nullable', 'integer'],
        ];
    }

    protected function statusTabs(): array
    {
        return ['all' => 'Todos', 'Pendiente' => 'Pendiente', 'En ruta' => 'En ruta', 'Entregado' => 'Entregado', 'Retrasado' => 'Retrasado', 'Cancelado' => 'Cancelado'];
    }

    protected function selectOptions(): array
    {
        $clients = data_get(app(ClientsApiService::class)->list(['page_size' => 100]), 'data.items', []);
        $statuses = data_get(app(PackageStatusesApiService::class)->list(['page_size' => 100]), 'data.items', []);

        return [
            'client_id' => collect($clients)->map(fn ($client) => [
                'value' => data_get($client, 'id'),
                'label' => data_get($client, 'email'),
            ])->values()->all(),
            'package_status_id' => collect($statuses)->map(fn ($status) => [
                'value' => data_get($status, 'id'),
                'label' => data_get($status, 'name'),
            ])->values()->all(),
        ];
    }
}

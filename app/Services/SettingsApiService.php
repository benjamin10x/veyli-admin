<?php

namespace App\Services;

class SettingsApiService
{
    public function __construct(protected FastApiService $api)
    {
    }

    public function get(): array
    {
        return $this->api->get('/settings');
    }

    public function updateSystem(array $payload): array
    {
        return $this->api->put('/settings/system', $payload);
    }

    public function updateNotifications(array $payload): array
    {
        return $this->api->put('/settings/notifications', $payload);
    }

    public function notificationFeed(): array
    {
        return $this->api->get('/settings/notifications/feed');
    }
}

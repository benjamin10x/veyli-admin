<?php

namespace App\Services;

class PackagesApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/packages';
    }

    public function patchStatus(int $id, array $payload): array
    {
        return $this->api->patch($this->endpoint()."/{$id}/status", $payload);
    }
}

<?php

namespace App\Services;

abstract class AbstractResourceApiService
{
    public function __construct(protected FastApiService $api)
    {
    }

    abstract protected function endpoint(): string;

    public function list(array $query = []): array
    {
        return $this->api->get($this->endpoint(), $query);
    }

    public function find(int $id): array
    {
        return $this->api->get($this->endpoint()."/{$id}");
    }

    public function create(array $payload): array
    {
        return $this->api->post($this->endpoint(), $payload);
    }

    public function update(int $id, array $payload): array
    {
        return $this->api->put($this->endpoint()."/{$id}", $payload);
    }

    public function patchStatus(int $id, array $payload): array
    {
        return $this->api->patch($this->endpoint()."/{$id}/status", $payload);
    }
}

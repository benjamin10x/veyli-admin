<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class FastApiService
{
    protected function client(): PendingRequest
    {
        $token = session('api_token');

        return Http::baseUrl(rtrim(config('services.fastapi.url'), '/'))
            ->acceptJson()
            ->timeout((int) config('services.fastapi.timeout', 15))
            ->when($token, fn ($http) => $http->withToken($token));
    }

    public function get(string $uri, array $query = []): array
    {
        return $this->send('GET', $uri, [], $query);
    }

    public function rawGet(string $uri, array $query = []): Response
    {
        $response = $this->client()->send('GET', ltrim($uri, '/'), [
            'query' => array_filter($query, static fn ($value) => $value !== null && $value !== ''),
        ]);

        if ($response->successful()) {
            return $response;
        }

        $this->throwFromResponse($response);
    }

    public function post(string $uri, array $data = []): array
    {
        return $this->send('POST', $uri, $data);
    }

    public function put(string $uri, array $data = []): array
    {
        return $this->send('PUT', $uri, $data);
    }

    public function patch(string $uri, array $data = []): array
    {
        return $this->send('PATCH', $uri, $data);
    }

    public function delete(string $uri, array $data = []): array
    {
        return $this->send('DELETE', $uri, $data);
    }

    protected function send(string $method, string $uri, array $data = [], array $query = []): array
    {
        $response = $this->client()->send($method, ltrim($uri, '/'), [
            'query' => array_filter($query, static fn ($value) => $value !== null && $value !== ''),
            'json' => $data,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        $this->throwFromResponse($response);
    }

    protected function throwFromResponse(Response $response): never
    {
        $body = $response->json();
        $message = data_get($body, 'detail')
            ?? data_get($body, 'message')
            ?? 'La API no pudo procesar la solicitud.';

        if ($response->status() === 422) {
            throw new ApiValidationException(
                is_string($message) ? $message : 'Validación fallida.',
                422,
                ['errors' => $this->extractValidationErrors(data_get($body, 'detail', []))]
            );
        }

        throw new ApiException(
            is_string($message) ? $message : 'Error inesperado en la API.',
            $response->status(),
            ['response' => $body]
        );
    }

    protected function extractValidationErrors(mixed $detail): array
    {
        if (!is_array($detail)) {
            return ['api' => [is_string($detail) ? $detail : 'Validación fallida.']];
        }

        $errors = [];

        foreach ($detail as $error) {
            if (!is_array($error)) {
                continue;
            }

            $location = $error['loc'] ?? ['api'];
            $field = is_array($location) ? end($location) : 'api';
            $errors[$field][] = $error['msg'] ?? 'Validación inválida.';
        }

        return $errors ?: ['api' => ['Validación fallida.']];
    }
}

<?php

namespace App\Services;

class AuthApiService
{
    public function __construct(protected FastApiService $api)
    {
    }

    public function login(string $email, string $password): array
    {
        return $this->api->post('/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function registerStaff(string $name, string $email, string $password, string $roleName): array
    {
        return $this->api->post('/auth/register/staff', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role_name' => $roleName,
        ]);
    }

    public function registerClient(string $firstName, string $lastName, string $email, string $password): array
    {
        return $this->api->post('/auth/register/client', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
            'state' => 'active',
        ]);
    }

    public function me(): array
    {
        return $this->api->get('/auth/me');
    }

    public function updateProfile(array $payload): array
    {
        return $this->api->put('/auth/me/profile', $payload);
    }
}

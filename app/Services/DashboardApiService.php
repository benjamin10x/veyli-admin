<?php

namespace App\Services;

class DashboardApiService
{
    public function __construct(protected FastApiService $api)
    {
    }

    public function summary(): array
    {
        return $this->api->get('/dashboard/summary');
    }
}

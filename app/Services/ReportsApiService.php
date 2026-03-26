<?php

namespace App\Services;

use Illuminate\Http\Client\Response;

class ReportsApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/reports';
    }

    public function summary(array $query): array
    {
        return $this->api->get('/reports/summary', $query);
    }

    public function export(array $query, string $format): Response
    {
        return $this->api->rawGet('/reports/export', [
            ...$query,
            'fmt' => $format,
        ]);
    }
}

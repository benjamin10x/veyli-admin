<?php

namespace App\Services;

class ClientsApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/clients';
    }
}

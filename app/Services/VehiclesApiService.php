<?php

namespace App\Services;

class VehiclesApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/vehicles';
    }
}

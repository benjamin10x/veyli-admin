<?php

namespace App\Services;

class RoutesApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/routes';
    }
}

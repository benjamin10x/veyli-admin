<?php

namespace App\Services;

class DriversApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/drivers';
    }
}

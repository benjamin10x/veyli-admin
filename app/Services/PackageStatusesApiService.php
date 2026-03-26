<?php

namespace App\Services;

class PackageStatusesApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/package-statuses';
    }
}

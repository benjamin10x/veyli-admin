<?php

namespace App\Services;

class AssignmentsApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/assignments';
    }
}

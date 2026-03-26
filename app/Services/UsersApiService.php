<?php

namespace App\Services;

class UsersApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/users';
    }
}

<?php

namespace App\Services;

class RolesApiService extends AbstractResourceApiService
{
    protected function endpoint(): string
    {
        return '/roles';
    }

    public function permissionCatalog(): array
    {
        return $this->api->get('/roles/meta/permissions');
    }
}

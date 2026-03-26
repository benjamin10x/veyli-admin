<?php

namespace App\Exceptions;

class ApiValidationException extends ApiException
{
    public function errors(): array
    {
        return $this->context()['errors'] ?? [];
    }
}

<?php

namespace App\Services\Contracts;

use App\Domains\DTO\CreateUserDTO;

interface SsoServiceInterface
{
    public function createUser(CreateUserDTO $createUserDTO);
}
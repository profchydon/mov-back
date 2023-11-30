<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\UpdateCompanyUserDTO;
use App\Models\Company;
use App\Models\User;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{
    public function getUsers(Company|string $company);

    public function updateCompanyUser(User|string $user, UpdateCompanyUserDTO $updateUserTeamDTO);
}

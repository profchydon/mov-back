<?php

namespace App\Repositories;

use App\Models\UserCompany;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;

class UserCompanyRepository extends BaseRepository implements UserCompanyRepositoryInterface
{
    public function model(): string
    {
        return UserCompany::class;
    }
}

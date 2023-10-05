<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository
    ) {
    }

    public function fetchUserRoles(Company $company)
    {
        $roles = $this->roleRepository->all();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $roles);
    }
}

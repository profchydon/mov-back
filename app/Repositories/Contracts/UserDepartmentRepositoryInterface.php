<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use App\Models\Department;

interface UserDepartmentRepositoryInterface extends BaseRepositoryInterface
{

    public function addBulkUserstoDepartment(array $members, string $company_id, string $department_id);
}

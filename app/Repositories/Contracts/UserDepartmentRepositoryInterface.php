<?php

namespace App\Repositories\Contracts;

interface UserDepartmentRepositoryInterface extends BaseRepositoryInterface
{
    public function addBulkUserstoDepartment(array $members, string $company_id, string $department_id);
}

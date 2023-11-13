<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateDepartmentDTO;
use App\Models\Company;
use App\Models\Department;

interface DepartmentRepositoryInterface
{
    public function getDepartments(Company|string $company);

    public function get(Department|string $department);

    public function create(CreateDepartmentDTO $departmentDTO);

    public function update(Department|string $department, CreateDepartmentDTO $departmentDTO);

    public function delete(Department|string $department);

    public function getDepartmentUsers(Company|string $company, Department|string $department);
}

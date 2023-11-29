<?php

namespace App\Repositories;

use App\Domains\DTO\CreateDepartmentDTO;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\DepartmentResource;
use App\Models\Company;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getDepartments(Company|string $company, $relation = [])
    {
        if (!($company instanceof  Company)) {
            $company = Department::findOrFail($company);
        }

        $departments = $company->departments()->with($relation);
        $departments = Department::appendToQueryFromRequestQueryParameters($departments);
        $departments = $departments->paginate();

        return DepartmentCollection::make($departments);
    }

    public function get(Department|string $department, $relation = [])
    {
        // if (!($department instanceof  Department)) {
        //     $department = Department::findOrFail($department);
        // }

        $department = Department::whereId($department->id)->with($relation)->first();

        return DepartmentResource::make($department);
    }

    public function create(CreateDepartmentDTO $departmentDTO)
    {
        $department = Department::firstOrCreate($departmentDTO->toArray());

        return DepartmentResource::make($department->load('head', 'company'));
    }

    public function update(Department|string $department, CreateDepartmentDTO $departmentDTO)
    {
        if (!($department instanceof  Department)) {
            $department = Department::findOrFail($department);
        }

        $department->update($departmentDTO->toSynthensizedArray());

        return DepartmentResource::make($department->load('head', 'company'));
    }

    public function delete(Department|string $department)
    {
        if (!($department instanceof  Department)) {
            $department = Department::findOrFail($department);
        }

        $department->deleteOrFail();
    }

    public function getDepartmentUsers(Company|string $company, Department|string $department)
    {
        if (!($department instanceof  Department)) {
            $department = Department::findOrFail($department);
        }

        return $department->members;
    }
}

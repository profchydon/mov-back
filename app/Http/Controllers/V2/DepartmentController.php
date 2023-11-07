<?php

namespace App\Http\Controllers\V2;

use App\Domains\DTO\CreateDepartmentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Contracts\UserDepartmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly DepartmentRepositoryInterface $departmentRepository,
        private readonly UserDepartmentRepositoryInterface $userDepartmentRepository,
    ) {
    }

    public function index(Company $company, Request $request)
    {
        $departments = $this->departmentRepository->getDepartments($company);

        return $this->response(Response::HTTP_OK, __('record_fetched'), $departments);
    }

    public function store(Company $company, CreateDepartmentRequest $request)
    {
        $departmentDTO = new CreateDepartmentDTO();
        $departmentDTO->setCompanyId($company->id)
            ->setTenantId($company->tenant_id)
            ->setName($request->name)
            ->setHeadId($request->head_id);

        $department = $this->departmentRepository->create($departmentDTO);

        if ($department && !empty($request->members)) {
            /**
             * @var array
             */
            $members = $request->members;

            $coo = $this->userDepartmentRepository->addBulkUserstoDepartment($members, $company->id, $department->id);
        }

        return $this->response(Response::HTTP_CREATED, __('record-created'), $department);
    }

    public function show(Company $company, Department $department)
    {
        $department = $this->departmentRepository->get($department);

        return $this->response(Response::HTTP_OK, __('record-fetched'), $department);
    }

    public function update(Company $company, Department $department, UpdateDepartmentRequest $request)
    {
        $departmentDTO = new CreateDepartmentDTO();
        $departmentDTO->setCompanyId($company->id)
            ->setTenantId($company->tenant_id)
            ->setName($request->name)
            ->setHeadId($request->head_id);

        $department = $this->departmentRepository->update($department, $departmentDTO);

        return $this->response(Response::HTTP_OK, __('record-updated'), $department);
    }

    public function destroy(Company $company, Department $department)
    {
        $this->departmentRepository->delete($department);

        return $this->noContent();
    }

    public function getDepartmentUsers(Company $company, Department $department)
    {
        $departmentUsers = $this->departmentRepository->getDepartmentUsers($company, $department);

        return $this->response(Response::HTTP_OK, __('record-fetched'), $departmentUsers);

    }

}

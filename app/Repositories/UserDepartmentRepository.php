<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Department;
use App\Models\UserCompany;
use Illuminate\Support\Facades\DB;
use App\Domains\Constant\UserDepartmentConstant;
use App\Models\UserDepartment;
use App\Repositories\Contracts\UserDepartmentRepositoryInterface;

class UserDepartmentRepository extends BaseRepository implements UserDepartmentRepositoryInterface
{
    public function model(): string
    {
        return UserDepartment::class;
    }

    public function addBulkUserstoDepartment(array $members, string $company_id, string $department_id): bool
    {

        try {

            DB::transaction(function () use ($members, $company_id, $department_id) {

                foreach ($members as $user_id) {

                    $this->model->create([
                        UserDepartmentConstant::COMPANY_ID => $company_id,
                        UserDepartmentConstant::USER_ID => $user_id,
                        UserDepartmentConstant::DEPARTMENT_ID => $department_id,
                    ]);
                }
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

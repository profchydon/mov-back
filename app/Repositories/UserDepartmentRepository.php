<?php

namespace App\Repositories;

use App\Domains\Constant\UserDepartmentConstant;
use App\Models\UserDepartment;
use App\Repositories\Contracts\UserDepartmentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserDepartmentRepository extends BaseRepository implements UserDepartmentRepositoryInterface
{
    public function model(): string
    {
        return UserDepartment::class;
    }

    public function addBulkUserstoDepartment(?array $members, string $company_id, string $department_id): bool
    {
        try {
            DB::transaction(function () use ($members, $company_id, $department_id) {

                foreach ($members as $user_id) {

                    $userInDepartment = $this->userExistInDepartment($user_id, $department_id);

                    if (!$userInDepartment) {
                        $this->model->create([
                            UserDepartmentConstant::COMPANY_ID => $company_id,
                            UserDepartmentConstant::USER_ID => $user_id,
                            UserDepartmentConstant::DEPARTMENT_ID => $department_id,
                        ]);
                    }
                }
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function userExistInDepartment(string $user_id, string $department_id): bool
    {
        return $this->model->where(UserDepartmentConstant::USER_ID, $user_id)->where(UserDepartmentConstant::DEPARTMENT_ID, $department_id)->exists();
    }
}

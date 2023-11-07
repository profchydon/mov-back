<?php

namespace App\Repositories;

use App\Domains\Constant\UserTeamConstant;
use App\Models\UserTeam;
use App\Repositories\Contracts\UserTeamRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserTeamRepository extends BaseRepository implements UserTeamRepositoryInterface
{
    public function model(): string
    {
        return UserTeam::class;
    }

    public function addBulkUserstoTeam(?array $members, string $company_id, string $team_id, string $department_id): bool
    {
        try {
            DB::transaction(function () use ($members, $company_id, $team_id, $department_id) {
                foreach ($members as $user_id) {
                    $this->model->create([
                        UserTeamConstant::COMPANY_ID => $company_id,
                        UserTeamConstant::USER_ID => $user_id,
                        UserTeamConstant::DEPARTMENT_ID => $department_id,
                        UserTeamConstant::TEAM_ID => $team_id,
                    ]);
                }
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

<?php

namespace App\Repositories;

use App\Domains\Constant\UserTeamConstant;
use App\Domains\DTO\UpdateUserTeamDTO;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
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

                    $userInTeam = $this->userExistInTeam($user_id, $team_id);

                    if (!$userInTeam) {

                        $this->model->create([
                            UserTeamConstant::COMPANY_ID => $company_id,
                            UserTeamConstant::USER_ID => $user_id,
                            UserTeamConstant::DEPARTMENT_ID => $department_id,
                            UserTeamConstant::TEAM_ID => $team_id,
                        ]);
                    }
                }
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    public function userExistInTeam(string $user_id, string $team_id): bool
    {
        return $this->model->where(UserTeamConstant::USER_ID, $user_id)->where(UserTeamConstant::TEAM_ID, $team_id)->exists();
    }

    public function updateUserTeams(UpdateUserTeamDTO $updateUserTeamDTO)
    {

        try {

            DB::transaction(function () use ($updateUserTeamDTO) {

                $dto = $updateUserTeamDTO->toArray();

                foreach ($dto['teams'] as $team) {

                    $condition = [
                        UserTeamConstant::USER_ID =>  $dto['user_id'],
                        UserTeamConstant::COMPANY_ID =>  $dto['company_id'],
                        UserTeamConstant::DEPARTMENT_ID =>  $dto['department_id'],
                        UserTeamConstant::TEAM_ID =>  $team,
                    ];

                    $this->model->firstOrCreate($condition, $condition);
                }

                $this->model->where(UserTeamConstant::USER_ID, $dto['user_id'])
                    ->where(UserTeamConstant::COMPANY_ID, $dto['company_id'])
                    ->where(UserTeamConstant::DEPARTMENT_ID, $dto['department_id'])
                    ->whereNotIn('team_id', $dto['teams'])->delete();
            });

            return true;
        } catch (\Throwable $th) {

            return false;
        }
    }
}

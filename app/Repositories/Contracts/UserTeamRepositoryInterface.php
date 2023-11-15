<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\UpdateUserTeamDTO;

interface UserTeamRepositoryInterface extends BaseRepositoryInterface
{
    public function addBulkUserstoTeam(array $members, string $company_id, string $team_id, string $department_id);

    public function userExistInTeam(string $user_id, string $team_id);

    public function updateUserTeams(UpdateUserTeamDTO $updateUserTeamDTO);
}

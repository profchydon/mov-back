<?php

namespace App\Repositories\Contracts;

interface UserTeamRepositoryInterface extends BaseRepositoryInterface
{
    public function addBulkUserstoTeam(array $members, string $company_id, string $team_id, string $department_id);
}

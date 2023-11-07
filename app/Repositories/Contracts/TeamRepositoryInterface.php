<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateTeamDTO;
use App\Models\Department;

interface TeamRepositoryInterface
{
    public function create(CreateTeamDTO $teamDTO);

    public function getTeams(Department|string $department);
}

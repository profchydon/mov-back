<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateTeamDTO;

interface TeamRepositoryInterface
{
    public function create(CreateTeamDTO $teamDTO);
}

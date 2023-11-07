<?php

namespace App\Repositories;

use App\Domains\DTO\CreateTeamDTO;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Repositories\Contracts\TeamRepositoryInterface;

class TeamRepository implements TeamRepositoryInterface
{
    public function model(): string
    {
        return Team::class;
    }

    public function create(CreateTeamDTO $teamDTO)
    {
        $team = Team::firstOrCreate($teamDTO->toArray());

        return TeamResource::make($team);
    }
}

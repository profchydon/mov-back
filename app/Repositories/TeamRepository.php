<?php

namespace App\Repositories;

use App\Domains\Constant\TeamConstant;
use App\Domains\DTO\CreateTeamDTO;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Company;
use App\Models\Department;
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

    public function getTeams(Department|string $department)
    {
        if (!($department instanceof  Department)) {
            $department = Department::findOrFail($department);
        }

        $teams = $department->teams();
        $teams = Team::appendToQueryFromRequestQueryParameters($teams);
        $teams = $teams->paginate();

        return TeamCollection::make($teams);
    }

    public function getTeamsInDepts(Company $company, array $departments)
    {
        return Team::where(TeamConstant::COMPANY_ID, $company->id)->whereIn(TeamConstant::DEPARTMENT_ID, $departments)->get();
    }


}

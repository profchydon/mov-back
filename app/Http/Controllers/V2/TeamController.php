<?php

namespace App\Http\Controllers\V2;

use App\Domains\DTO\CreateTeamDTO;
use App\Domains\DTO\UpdateUserTeamDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\GetDeptsTeamsRequest;
use App\Http\Requests\UpdateUserTeamRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\UserTeamRepositoryInterface;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function __construct(private readonly TeamRepositoryInterface $teamRepository, private readonly UserTeamRepositoryInterface $userTeamRepository)
    {
    }

    public function createTeam(Company $company, Department $department, CreateTeamRequest $request)
    {
        $teamDTO = new CreateTeamDTO();
        $teamDTO->setCompanyId($company->id)
            ->setTenantId($company->tenant_id)
            ->setName($request->name)
            ->setDepartmentId($department->id)
            ->setTeamLead($request->team_lead);

        $team = $this->teamRepository->create($teamDTO);

        if ($team && !empty($team->members)) {
            /**
             * @var array
             */
            $members = $request->members;

            $this->userTeamRepository->addBulkUserstoTeam($members, $company->id, $team->id, $department->id);
        }

        return $this->response(Response::HTTP_CREATED, __('record-created'), $team);
    }

    public function getTeams(Company $company, Department $department)
    {
        $teams = $this->teamRepository->getTeams($department);

        return $this->response(Response::HTTP_OK, __('record-fetched'), $teams);
    }

    public function updateUserTeams(Company $company, Department $department, User $user, UpdateUserTeamRequest $request)
    {
        $updateTeamDTO = new UpdateUserTeamDTO();
        $updateTeamDTO->setTeams($request->teams)
            ->setCompanyId($company->id)
            ->setUserId($user->id)
            ->setDepartmentId($department->id);

        $this->userTeamRepository->updateUserTeams($updateTeamDTO);

        return $this->response(Response::HTTP_OK, __('record-update'));
    }

    public function getTeamsInDepts(Company $company, GetDeptsTeamsRequest $request)
    {
        $teams = $this->teamRepository->getTeamsInDepts($company, $request->departments);

        return $this->response(Response::HTTP_OK, __('record-fetched'), $teams);
    }
}

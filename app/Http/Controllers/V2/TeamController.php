<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\SubscriptionConstant;
use App\Domains\DTO\CreateTeamDTO;
use App\Domains\Enum\User\UserStageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\SelectSubscriptionPlanRequest;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Company;
use App\Models\Department;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Team;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\UserTeamRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function __construct(private readonly TeamRepositoryInterface $teamRepository, private readonly UserTeamRepositoryInterface $userTeamRepository)
    {
    }

    public function createTeam(Company $company, Department $department,  CreateTeamRequest $request)
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
}

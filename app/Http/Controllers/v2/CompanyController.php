<?php

namespace App\Http\Controllers\v2;

use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Domains\Enum\User\UserStageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\InviteUserRequest;
use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository, 
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserCompanyRepositoryInterface $userCompanyRepository,
        private readonly UserInvitationRepositoryInterface $userInvitationRepository
    )
    { 
    }

    public function create(CreateCompanyRequest $request): JsonResponse
    {
        $user = $this->userRepository->first('id', '9a320b0d-cb24-4cf9-b6de-f77407fde3ae'); //this is only temporary till we finish up auth

        if($user->stage != UserStageEnum::COMPANY_DETAILS->value){
            return $this->error(Response::HTTP_BAD_REQUEST, 'Make sure you complete previous steps');
        }

        $tenant = $this->tenantRepository->create($request->getTenantDTO()->toArray());

        $companyDto = $request->getCompanyDTO()->setTenantId($tenant->id);
        
        $company = $this->companyRepository->create($companyDto->toArray());

        $this->userCompanyRepository->create([
            'tenant_id' => $tenant->id,
            'company_id' => $company->id,
            'user_id' => $user->id,
            'status' => UserCompanyStatusEnum::ACTIVE->value
        ]);

        $this->userRepository->updateById($user->id, [
            'stage' => UserStageEnum::USERS->value
            ]);

        return $this->response(
            Response::HTTP_CREATED,
            'You have successfully created a company',
            $company
        );
    }

    public function inviteCompanyUsers(InviteUserRequest $request, Company $company)
    {
        $user = $this->userRepository->first('id', '9a320b0d-cb24-4cf9-b6de-f77407fde3ae'); //this is only temporary till we finish up auth

        if($user->stage != UserStageEnum::USERS->value){
            return $this->error(Response::HTTP_BAD_REQUEST, 'Make sure you complete previous steps');
        }

        $DTOs = $request->getInvitationData($company->id, $user->id);
        $this->userInvitationRepository->inviteCompanyUsers($DTOs);

        $this->userRepository->updateById($user->id, [
            'stage' => UserStageEnum::COMPLETED->value
            ]);

        return $this->response(
            Response::HTTP_CREATED,
            'You have successfully invited users',
        );
    }
}

<?php

namespace App\Http\Controllers\v2;

use App\Domains\DTO\CreateCompanyDTO;
use App\Domains\DTO\CreateTenantDTO;
use App\Domains\Enum\User\UserAccountStageEnum;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\InviteUserRequest;
use App\Http\Resources\CompanyResource;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository, 
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserCompanyRepositoryInterface $userCompanyRepository
    )
    { 
    }

    public function create(CreateCompanyRequest $request): JsonResponse
    {
        $user = $this->userRepository->first('id', '9a2fc736-acf2-483c-9eeb-b4c0725da1aa'); //this is only temporary till we finish up auth

        if($user->stage != UserAccountStageEnum::COMPANY_DETAILS->value){
            return $this->error(Response::HTTP_BAD_REQUEST, 'Make sure you complete previous steps');
        }

        $tenantDto = new CreateTenantDTO($request->name);
        $tenant = $this->tenantRepository->create($tenantDto);

        $data = array_merge($request->all(), ['tenant_id' => $tenant->id]);
        $companyDto = CreateCompanyDTO::fromArray($data);
        
        $company = $this->companyRepository->create($companyDto);

        $this->userCompanyRepository->create([
            'tenant_id' => $tenant->id,
            'company_id' => $company->id,
            'user_id' => $user->id,
            'status' => UserCompanyStatusEnum::ACTIVE->value
        ]);

        $this->userRepository->updateById($user->id, [
            'stage' => UserAccountStageEnum::SUBSCRIPTION_PLAN->value
            ]);

        return $this->response(
            Response::HTTP_CREATED,
            'You have successfully created a company',
            $company
        );
    }

    public function inviteUsers(InviteUserRequest $request)
    {
        
    }
}

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
use App\Models\User;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepositoryInterface, 
        private readonly CompanyRepositoryInterface $companyRepositoryInterface,
        private readonly UserRepositoryInterface $userRepositoryInterface,
        private readonly UserCompanyRepositoryInterface $userCompanyRepositoryInterface
    )
    { 
    }

    public function create(CreateCompanyRequest $request): JsonResponse
    {
        $user = $this->userRepositoryInterface->first('id', '84b1e376-209b-4040-9be1-b41938ee1cb4'); //this is only temporary till we finish up auth

        if($user->stage != UserAccountStageEnum::COMPANY_DETAILS->value){
            return $this->error(Response::HTTP_BAD_REQUEST, 'Make sure you complete previous steps');
        }

        $tenantDto = new CreateTenantDTO($request->name);
        $tenant = $this->tenantRepositoryInterface->create($tenantDto);

        $data = array_merge($request->all(), ['tenant_id' => $tenant->id]);
        $companyDto = CreateCompanyDTO::fromArray($data);
        
        $company = $this->companyRepositoryInterface->create($companyDto);

        $this->userCompanyRepositoryInterface->create([
            'tenant_id' => $tenant->id,
            'company_id' => $company->id,
            'user_id' => $user->id,
            'status' => UserCompanyStatusEnum::ACTIVE->value
        ]);

        $this->userRepositoryInterface->updateById($user->id, [
            'stage' => UserAccountStageEnum::SUBSCRIPTION_PLAN->value
            ]);

        return $this->response(
            Response::HTTP_CREATED,
            'You have successfully created a company',
            new CompanyResource($company)
        );
    }

    public function inviteUsers(InviteUserRequest $request)
    {
        
    }
}

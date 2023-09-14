<?php

namespace App\Http\Controllers\v2;

use App\Domains\DTO\CreateCompanyDTO;
use App\Domains\DTO\CreateTenantDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\InviteUserRequest;
use App\Http\Resources\CompanyResource;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(private readonly TenantRepositoryInterface $tenantRepositoryInterface, private readonly CompanyRepositoryInterface $companyRepositoryInterface)
    { 
    }

    public function create(CreateCompanyRequest $request): JsonResponse
    {
        $tenantDto = new CreateTenantDTO($request->validated('name'));
        $tenant = $this->tenantRepositoryInterface->create($tenantDto);

        $data = array_merge($request->all(), ['tenant_id' => $tenant->id]);
        $companyDto = CreateCompanyDTO::fromArray($data);

        $company = $this->companyRepositoryInterface->create($companyDto);

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

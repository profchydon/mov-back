<?php

namespace App\Repositories;

use App\Domains\Constant\OfficeConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Models\Company;
use App\Models\Office;
use App\Models\OfficeArea;
use App\Models\UserInvitation;
use App\Repositories\Contracts\CompanyOfficeRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface, CompanyOfficeRepositoryInterface
{
    public function model(): string
    {
        return Company::class;
    }

    public function createCompanyOffice(CreateCompanyOfficeDTO $companyOfficeDTO)
    {
        return Office::firstOrCreate($companyOfficeDTO->toArray());
    }

    public function createOfficeArea(Office|string $office, string $name)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        return $office->areas()->create([
            'name' => $name,
            'tenant_id' => $office->tenant_id,
        ]);
    }

    public function getCompanyOffices(Company|string $company)
    {
        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }

        $offices = $company->offices()->withCount('areas');
        $offices = Office::appendToQueryFromRequestQueryParameters($offices);

        return $offices->paginate();
    }

    public function getCompanyOffice(Office|string $office)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        return $office->load('areas');
    }

    public function deleteCompanyOffice(Office|string $office)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        DB::beginTransaction();
        $office->areas()->delete();
        $office->deleteOrFail();
        DB::commit();
    }

    public function updateCompanyOffice(Office|string $office, CreateCompanyOfficeDTO $officeDTO)
    {
        if (!($office instanceof Office)) {
            $office = Office::findOrFail($office);
        }

        $office->update($officeDTO->toSynthensizedArray());

        return $office->fresh();
    }

    public function getOfficeAreas(Office|string $office)
    {
        $officeAreas = OfficeArea::where(OfficeConstant::OFFICE_ID, $office->id)->get();

        return $officeAreas;
    }

    public function updateOfficeArea(OfficeArea|string $officeArea, array $attributes)
    {
        if (!($officeArea instanceof OfficeArea)) {
            $officeArea = OfficeArea::findOrFail($officeArea);
        }

        $officeArea->update($attributes);

        return $officeArea->fresh();
    }

    public function deleteOfficeArea(OfficeArea|string $officeArea)
    {
        if (!($officeArea instanceof OfficeArea)) {
            $officeArea = OfficeArea::findOrFail($officeArea);
        }

        $officeArea->deleteOrFail();
    }

    public function getUsers(Company|string $company)
    {
        if (!($company instanceof Company)) {
            $company = Company::findOrFail($company);
        }
        
        $users = UserInvitation::with(['role', 'team', 'department', 'office'])->where(UserInvitationConstant::COMPANY_ID, $company->id);
        
        $users = UserInvitation::appendToQueryFromRequestQueryParameters($users);

        return $users;
    }
}

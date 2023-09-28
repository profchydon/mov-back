<?php

namespace App\Repositories;

use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Models\Company;
use App\Models\Office;
use App\Repositories\Contracts\CompanyOfficeRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;

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
}

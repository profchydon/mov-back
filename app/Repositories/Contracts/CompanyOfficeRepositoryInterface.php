<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Models\Company;
use App\Models\Office;
use App\Models\OfficeArea;

interface CompanyOfficeRepositoryInterface
{
    public function createCompanyOffice(CreateCompanyOfficeDTO $officeCompanyDTO);

    public function createOfficeArea(Office|string $office, string $name);

    public function getCompanyOffices(Company|string $company);

    public function getCompanyOffice(Office|string $office);

    public function updateCompanyOffice(Office|string $office, CreateCompanyOfficeDTO $officeDTO);

    public function getOfficeAreas(Office|string $office);

    public function updateOfficeArea(OfficeArea|string $officeArea, array $attributes);

    public function deleteCompanyOffice(Office|string $office);

    public function deleteOfficeArea(OfficeArea|string $officeArea);
}

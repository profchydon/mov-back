<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Models\Company;
use App\Models\Office;

interface CompanyOfficeRepositoryInterface
{
    public function createCompanyOffice(CreateCompanyOfficeDTO $officeCompanyDTO);

    public function createOfficeArea(Office|string $office, string $name);

    public function getCompanyOffices(Company|string $company);

    public function getCompanyOffice(Office|string $office);
}

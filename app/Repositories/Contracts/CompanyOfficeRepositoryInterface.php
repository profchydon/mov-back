<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Models\Office;

interface CompanyOfficeRepositoryInterface
{
    public function createCompanyOffice(CreateCompanyOfficeDTO $officeCompanyDTO);

    public function createOfficeArea(Office|string $office, string $name);
}

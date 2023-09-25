<?php

namespace App\Services\Contracts;

use App\Domains\DTO\CreateSSOCompanyDTO;

interface SSOServiceInterface
{
    public function createSSOCompany(CreateSSOCompanyDTO $createSSOCompanyDTO);
    
    public function sendEmailOTP(string $email);
}

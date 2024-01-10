<?php

namespace App\Services\Contracts;

use App\Domains\DTO\AddCompanyDetailsDTO;
use App\Domains\DTO\CreateSSOCompanyDTO;
use App\Domains\DTO\CreateSSOUserDTO;
use App\Domains\DTO\VerifyOTPDTO;

interface SSOServiceInterface
{
    public function createSSOCompany(CreateSSOCompanyDTO $createSSOCompanyDTO);

    public function createEmailOTP(string $email);

    public function verifyOTP(VerifyOTPDTO $dto);

    public function updateCompany(AddCompanyDetailsDTO $dto, string $ssoCompanyId);

    public function createSSOUser(CreateSSOUserDTO $user, string $ssoCompanyId);
}

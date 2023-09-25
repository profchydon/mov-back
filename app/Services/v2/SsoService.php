<?php

namespace App\Services\v2;

use App\Domains\DTO\CreateSSOCompanyDTO;
use App\Services\Contracts\SSOServiceInterface;
use Illuminate\Support\Facades\Http;

class SSOService implements SSOServiceInterface
{

    public function createSSOCompany(CreateSSOCompanyDTO $createSSOCompanyDTO)
    {
        $url = sprintf('%s/api/oauth/register', env('SSO_URL'));

        $data = array(
            'company' => $createSSOCompanyDTO->getCompany()->toArray(),
            'user' => $createSSOCompanyDTO->getUser()->toArray(),
        );

        $resp = Http::acceptJson()->post($url, $data);

        return $resp;
    }

    public function sendEmailOTP(string $email)
    {
        $url = sprintf('%s/api/v1/otp', env('SSO_URL'));

        $data = [
            "type" => "email",
            "info" => $email
        ];
        
        $resp = Http::acceptJson()->post($url, $data);
        return $resp;
    }
}

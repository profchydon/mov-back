<?php
namespace App\Services\v2;

use App\Domains\DTO\CreateUserDTO;
use App\Services\Contracts\SsoServiceInterface;
use Illuminate\Support\Facades\Http;

class SsoService implements SsoServiceInterface
{

    public function createUser(CreateUserDTO $createUserDTO)
    {
        $url = sprintf('%s/api/oauth/register', env('SSO_URL'));

        $resp = Http::post($url, [
            'user' =>[
                "first_name" => $createUserDTO->getFirstName(),
                "last_name" => $createUserDTO->getLastName(),
                "email" => $createUserDTO->getEmail(),
                "password" => $createUserDTO->getPassword()
            ],
            'business' => [
                'phone_number' => $createUserDTO->getPhone()
            ]
        ]);

        return $resp;
    }
}
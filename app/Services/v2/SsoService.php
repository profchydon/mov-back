<?php
namespace App\Services\v2;

use App\Domains\DTO\CreateUserDTO;
use Illuminate\Support\Facades\Http;

class SsoService
{

    public function createUser(CreateUserDTO $createUserDTO)
    {
        $url = sprintf('%s/v1/sessions/register', env('SSO_URL'));

        $resp = Http::post($url, [
            'user' =>[
                "first_name" => $createUserDTO->first_name,
                "last_name" => $createUserDTO->last_name,
                "email" => $createUserDTO->email,
                "password" => $createUserDTO->password
            ],
            'business' => [
                'phone_number' => $createUserDTO->phone
            ]
        ]);

        return $resp;
    }
}
<?php

namespace App\Domains\DTO;

use App\Domains\Enum\User\UserAccountStageEnum;

class CreateUserDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $phone_code,
        public readonly string $phone,
        public readonly string $password,
        public readonly string $stage = UserAccountStageEnum::VERIFICATION->value
    )
    {  
    }

    static function fromArray(array $data): self
    {
        return new self(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone_code'],
            $data['phone'],
            $data['password'],
        );
    }
}
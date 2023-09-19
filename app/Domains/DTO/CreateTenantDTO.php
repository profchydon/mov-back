<?php
namespace App\Domains\DTO;

use App\Domains\Enum\Tenant\TenantStatusEnum;

class CreateTenantDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $status = TenantStatusEnum::ACTIVE->value
    )
    { 
    }
}
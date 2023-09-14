<?php
namespace App\Domains\DTO;

use App\Domains\Enum\Tenant\TenantStatusEnum;

class CreateTenantDTO
{
    public function __construct(
        public readonly $name,
        public readonly $status = TenantStatusEnum::ACTIVE->value
    )
    { 
    }
}
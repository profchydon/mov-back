<?php

namespace App\Domains\DTO;

class CreateCompanyDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $size,
        public readonly string $industry,
        public readonly string $address,
        public readonly string $country,
        public readonly string $state,
        public readonly string $tenant_id,
    )
    {}
    
    static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['size'],
            $data['industry'],
            $data['address'],
            $data['country'],
            $data['state'],
            $data['tenant_id']
        );
    }
}
<?php

namespace App\Domains\DTO;

use App\Domains\Enum\VendorStatusEnum;
use App\Traits\DTOToArray;

class CreateVendorDTO
{
    use DTOToArray;

    private string $name;
    private string $email;
    private string $phone;
    private string $address;
    private string $status;
    private string $tenant_id;
    private string $company_id;

    public function __construct()
    {
        $this->status = VendorStatusEnum::ACTIVE->value;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setTenantId(string $tenant_id)
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    public function getTenantId()
    {
        return $this->tenant_id;
    }

    public function setCompanyId(string $company_id)
    {
        $this->company_id = $company_id;
        return $this;
    }

    public function getCompanyId()
    {
        return $this->company_id;
    }
}

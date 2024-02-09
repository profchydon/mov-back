<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class CreateUserRoleDTO
{
    use DTOToArray;

    private string $name;
    private array $permissions;
    private string $company_id;
    private ?string $description;

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    public function getPermissions()
    {
        return $this->permissions;
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

    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
}

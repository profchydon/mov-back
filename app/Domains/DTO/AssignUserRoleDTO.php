<?php

namespace App\Domains\DTO;

use App\Domains\Enum\User\UserRoleStatusEnum;
use App\Models\User;
use App\Traits\DTOToArray;

class AssignUserRoleDTO
{
    use DTOToArray;

    private string $user;
    private string $role_id;
    private string $company_id;
    private ?string $office_id = null;
    private string $status;

    public function __construct()
    {
        $this->status = UserRoleStatusEnum::ACTIVE->value;
    }

    public function setUser(User|string $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setRole($role_id)
    {
        $this->role_id = $role_id;

        return $this;
    }

    public function getRole()
    {
        return $this->role_id;
    }

    public function setOffice(?string $office_id)
    {
        $this->office_id = $office_id;

        return $this;
    }

    public function getOffice()
    {
        return $this->office_id;
    }

    public function setCompany(string $company_id)
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getCompany()
    {
        return $this->company_id;
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
}

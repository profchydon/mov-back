<?php
namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class InviteCompanyUsersDTO
{
    use DTOToArray;

    private string $email;
    private int $role_id;
    private string $code;
    private string $company_id;
    private string $invited_by;

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setRoleId(int $role_id)
    {
        $this->role_id = $role_id;
        return $this;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
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

    public function setInvitedBy(string $invited_by)
    {
        $this->invited_by = $invited_by;
        return $this;
    }

    public function getInvitedBy()
    {
        return $this->invited_by;
    }
}
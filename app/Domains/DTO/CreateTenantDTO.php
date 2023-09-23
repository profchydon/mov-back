<?php
namespace App\Domains\DTO;

use App\Domains\Enum\Tenant\TenantStatusEnum;
use App\Traits\DTOToArray;

class CreateTenantDTO
{
    use DTOToArray;

    private string $name;
    private string $status = TenantStatusEnum::ACTIVE->value;

    public function setName(string $name){
        $this->name = $name;
        return $this;
    }

    public function getName(){
        return $this->name;
    }

    public function setStatus(string $status){
        $this->status = $status;
        return $this;
    }

    public function getStatus(){
        return $this->status;
    }
}
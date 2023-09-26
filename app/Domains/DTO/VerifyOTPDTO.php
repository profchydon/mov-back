<?php
namespace App\Domains\DTO;

use App\Traits\DTOToArray;

class VerifyOTPDTO
{
    use DTOToArray;
    
    private string $otp;
    private string $user_id;

    public function setOTP(string $otp)
    {
        $this->otp = $otp;
        return $this;
    }

    public function getOTP()
    {
        return $this->otp;
    }

    public function setUserId(string $user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
<?php

namespace App\Repositories;

use App\Models\OTP;
use App\Repositories\Contracts\OTPRepositoryInterface;

class OTPRepository extends BaseRepository implements OTPRepositoryInterface
{
    public function model(): string
    {
        return OTP::class;
    }
}

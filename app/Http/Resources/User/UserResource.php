<?php

namespace App\Http\Resources\User;

use App\Domains\Constant\UserConstant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            UserConstant::ID => $user->id,
            UserConstant::FIRST_NAME => $user->first_name,
            UserConstant::LAST_NAME => $user->last_name,
            UserConstant::EMAIL => $user->email,
            UserConstant::PHONE => $user->phone,
            UserConstant::COUNTRY_ID => $user->country_id,
            UserConstant::LAST_LOGIN => $user->last_login,
            UserConstant::JOB_TITLE => $user->job_title,
            UserConstant::STAGE => $user->stage,
            UserConstant::STATUS => $user->status,
        ];
    }
}

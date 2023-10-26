<?php

namespace App\Repositories;

use App\Domains\DTO\InviteCompanyUsersDTO;
use App\Models\UserInvitation;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use Illuminate\Support\Str;

class UserInvitationRepository extends BaseRepository implements UserInvitationRepositoryInterface
{
    public function model(): string
    {
        return UserInvitation::class;
    }

    public function inviteCompanyUser(InviteCompanyUsersDTO $userDto)
    {
        $code = (string) Str::uuid();
        $userDto->setCode($code);
        $this->create($userDto->toArray());
    }
}

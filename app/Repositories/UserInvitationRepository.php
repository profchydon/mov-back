<?php

namespace App\Repositories;

use App\Domains\DTO\InviteCompanyUsersDTO;
use App\Mail\CompanyUserInvitationEmail;
use App\Models\UserInvitation;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserInvitationRepository extends BaseRepository implements UserInvitationRepositoryInterface
{

    public function model(): string
    {
        return UserInvitation::class;
    }

    /**
     * @param array<int, InviteCompanyUsersDTO> $data
    */
    public function inviteCompanyUsers(array $data)
    {
        foreach($data as $userDto){
            $code  = (string) Str::uuid();
            $userDto->setCode($code);

            $invitedUser = $this->create($userDto->toArray());
            Mail::to($invitedUser->email)->queue(new CompanyUserInvitationEmail($invitedUser));
        }
    }
}

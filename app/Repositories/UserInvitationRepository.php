<?php

namespace App\Repositories;

use App\Models\UserInvitation;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserInvitationRepository extends BaseRepository implements UserRepositoryInterface
{

    public function model(): string
    {
        return UserInvitation::class;
    }
}

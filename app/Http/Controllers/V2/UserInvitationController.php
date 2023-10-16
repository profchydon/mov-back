<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\UserInvitationConstant;
use App\Http\Controllers\Controller;
use App\Models\UserInvitation;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserInvitationController extends Controller
{
    /**
     * @param UserInvitationRepositoryInterface $userInvitationRepository
     */
    public function __construct(
        private readonly UserInvitationRepositoryInterface $userInvitationRepository
    ) {
    }

    public function findUserInvitation($code)
    {
        $invitation = $this->userInvitationRepository->first(UserInvitationConstant::CODE, $code);

        if (!$invitation) {
            return $this->error(Response::HTTP_NOT_FOUND, __('messages.invite-not-found'));
        }

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $invitation);
    }
}

<?php

namespace App\Http\Controllers\v2;

use App\Domains\Constant\UserConstant;
use App\Exceptions\User\UserEmailNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResendOTPRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly SSOServiceInterface $ssoService
    )
    {
    }

    public function sendOTP(ResendOTPRequest $request)
    {
        $userExist = $this->userRepository->exist(UserConstant::EMAIL, $request->email);

        if(!$userExist){
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.email-not-found'));
        }

        $this->ssoService->sendEmailOTP($request->email);

        return $this->response(Response::HTTP_CREATED, __('messages.otp-resent'));
    }
}

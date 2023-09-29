<?php

namespace App\Http\Controllers\v2;

use App\Domains\Constant\UserConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResendOTPRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly SSOServiceInterface $ssoService,
    ) {
    }

    public function sendOTP(ResendOTPRequest $request)
    {
        try {
            $isExist = $this->userRepository->exist(UserConstant::EMAIL, $request->email);

            if (!$isExist) {
                return $this->error(Response::HTTP_BAD_REQUEST, __('messages.email-not-found'));
            }

            $this->ssoService->createEmailOTP($request->email);

            return $this->response(Response::HTTP_CREATED, __('messages.otp-resent'));
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
        }
    }

    public function verifyAccount(VerifyOTPRequest $request)
    {
        $isVerified = $this->ssoService->verifyOTP($request->getDTO());

        if ($isVerified) {
            return $this->response(Response::HTTP_OK, __('messages.otp-validated'));
        } else {
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.otp-invalid'));
        }
    }

    public function find(User $user) : JsonResponse {



        $response = [
            'user' => $user,
            'company' => $user->userCompanies()->get()
        ];

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $response);

    }
}

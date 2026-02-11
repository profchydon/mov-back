<?php

namespace App\Services\V2;

use App\Domains\Constant\UserConstant;
use App\Domains\DTO\AddCompanyDetailsDTO;
use App\Domains\DTO\CreateSSOCompanyDTO;
use App\Domains\DTO\CreateSSOUserDTO;
use App\Domains\DTO\VerifyOTPDTO;
use App\Domains\Enum\User\UserStageEnum;
use App\Repositories\Contracts\OTPRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;
use Carbon\Carbon;

class SSOService implements SSOServiceInterface
{
    public function __construct(
        private readonly OTPRepositoryInterface $otpRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function createSSOCompany(CreateSSOCompanyDTO $createSSOCompanyDTO)
    {
        $url = sprintf('%s/api/oauth/register', env('SSO_URL'));

        $data = [
            'company' => $createSSOCompanyDTO->getCompany()->toArray(),
            'user' => $createSSOCompanyDTO->getUser()->toArray(),
        ];

        $resp = Http::acceptJson()->post($url, $data);

        return $resp;
    }

    public function createEmailOTP(string $email)
    {
        $user = $this->userRepository->firstWithRelation(UserConstant::EMAIL, $email, ['otp']);

        if (!$user) {
            return null;
        }

        // generate a 4-digit OTP to match validation rules
        $otpCode = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        if ($user->otp) {
            $user->otp->delete();
        }

        $this->otpRepository->create([
            'sso_id' => $otpCode,
            'user_id' => $user->id,
        ]);

        // Send OTP email using local template
        Mail::to($user->email)->send(new OTPMail($user, $otpCode));

        return Response::HTTP_CREATED;
    }

    public function verifyOTP(VerifyOTPDTO $dto)
    {
        $user = $this->userRepository->firstWithRelation(UserConstant::ID, $dto->getUserId(), ['otp']);

        if (!$user || !$user->otp) {
            return false;
        }

        // OTP expired after 10 minutes
        $createdAt = Carbon::parse($user->otp->created_at);
        if ($createdAt->lt(Carbon::now()->subMinutes(10))) {
            $user->otp->delete();
            return false;
        }

        if ($dto->getOTP() !== $user->otp->sso_id) {
            return false;
        }

        $user->otp->delete();

        $user->update([
            UserConstant::STAGE => UserStageEnum::COMPANY_DETAILS->value,
        ]);

        return true;
    }

    public function updateCompany(AddCompanyDetailsDTO $dto, string $ssoCompanyId)
    {
        $url = sprintf('%s/api/v1/companies/%s', env('SSO_URL'), $ssoCompanyId);

        $data = $dto->toArray();

        $resp = Http::acceptJson()->put($url, $data);

        return $resp;
    }

    public function createSSOUser(CreateSSOUserDTO $dto, string $ssoCompanyId)
    {
        $url = sprintf('%s/api/v1/companies/%s/users', env('SSO_URL'), $ssoCompanyId);

        $data = $dto->toArray();

        $resp = Http::acceptJson()->post($url, $data);

        return $resp;
    }
}

<?php

namespace App\Services\V2;

use App\Domains\Constant\OTPConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\DTO\CreateSSOCompanyDTO;
use App\Domains\DTO\VerifyOTPDTO;
use App\Domains\Enum\User\UserStageEnum;
use App\Repositories\Contracts\OTPRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

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

        $data = array(
            'company' => $createSSOCompanyDTO->getCompany()->toArray(),
            'user' => $createSSOCompanyDTO->getUser()->toArray(),
        );

        $resp = Http::acceptJson()->post($url, $data);

        return $resp;
    }

    public function createEmailOTP(string $email)
    {
        $url = sprintf('%s/api/v1/otp', env('SSO_URL'));

        $data = [
            "type" => "email",
            "info" => $email
        ];

        $resp = Http::acceptJson()->post($url, $data);

        if ($resp->status() == Response::HTTP_CREATED) {
            $user = $this->userRepository->firstWithRelation(UserConstant::EMAIL, $email, ['otp']);

            $respData = $resp->json()['data'];
            if($user->otp){
                $user->otp->delete();
            }

            $this->otpRepository->create([
                OTPConstant::SSO_ID => $respData['id'],
                OTPConstant::USER_ID => $user->id,
            ]);
        }

        return $resp;
    }

    public function verifyOTP(VerifyOTPDTO $dto)
    {
        $user = $this->userRepository->firstWithRelation(UserConstant::ID, $dto->getUserId(), ['otp']);

        if(!$user || !$user->otp){
            return false;
        }

        $url = sprintf('%s/api/v1/otp/%s/verify', env('SSO_URL'), $user->otp->sso_id);

        $data = ["otp" => $dto->getOTP()];

        $resp = Http::acceptJson()->put($url, $data);

        if($resp->status() == Response::HTTP_OK){
            $user->otp->delete();

            $user->update([
                UserConstant::STAGE => UserStageEnum::COMPANY_DETAILS->value
            ]);

            return true;
        }else{
            return false;
        }
    }
}

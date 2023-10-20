<?php

namespace App\Http\Controllers\V2;

use App\Common\JWTHandler;
use App\Common\SerializePermission;
use App\Domains\Constant\UserConstant;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function authorization(Request $request)
    {
        $clientId = getenv('SSO_CLIENT_ID');
        $ssoUrl = getenv('SSO_URL');
        $state = Str::random(40);
        $redirectUrl = getenv('CORE_AUTH_CALLBACK_URL');
        $response_type = 'code';
        $scope = '';

        $authorizationUrl = sprintf('%s/oauth/authorize?client_id=%s&redirect_uri=%s&response_type=%s&state=%s&scope=%s', $ssoUrl, $clientId, $redirectUrl, $response_type, $state, $scope);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), ['redirect_url' => $authorizationUrl]);
    }

    public function confirmation(Request $request)
    {
        $ssoEndpoint = getenv('SSO_URL') . '/oauth/token';

        $response = Http::post($ssoEndpoint, [
            'grant_type' => 'authorization_code',
            'client_id' => getenv('SSO_CLIENT_ID'),
            'client_secret' => getenv('SSO_SECRET_ID'),
            'redirect_uri' => getenv('CORE_AUTH_CALLBACK_URL'),
            'code' => $request->code,
        ]);

        if ($response->status() !== Response::HTTP_OK) {
            return $this->error(Response::HTTP_UNAUTHORIZED, $response->json()['message']);
        }

        $response = (object) $response->json();

        $jwtToken = new JWTHandler($response);

        $sub = $jwtToken->getAccessTokenSubject();

        $response = $this->issueCoreAuthToken($sub);

        return $this->response(Response::HTTP_OK, __('messages.authenticated'), $response);
    }

    public function issueCoreAuthToken(string $sub)
    {
        $user = $this->userRepository->first(UserConstant::SSO_ID, $sub);

        $userRoles = $user->roles()->with('permissions')->get();

        $serializePermission = new SerializePermission($userRoles);

        return [
            'user' => $user,
            'permissions' => $serializePermission->stringifyPermission(),
            'auth_token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }

}

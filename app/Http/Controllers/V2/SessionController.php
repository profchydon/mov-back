<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function __construct()
    {
    }

    public function authorization(Request $request)
    {

        $clientId = getenv("SSO_CLIENT_ID");
        $ssoUrl = getenv("SSO_URL");
        $state = Str::random(40);
        $redirectUrl = getenv("CORE_AUTH_CALLBACK_URL");
        $response_type = 'code';
        $scope = '';

        $authorizationUrl = sprintf("%s/oauth/authorize?client_id=%s&redirect_uri=%s&response_type=%s&state=%s&scope=%s", $ssoUrl, $clientId, $redirectUrl, $response_type, $state, $scope);

        return response()->json(['redirect_url' => $authorizationUrl]);
    }

    public function confirmation(Request $request)
    {

        $ssoEndpoint = getenv('SSO_URL')."/oauth/token";

        $response = Http::post($ssoEndpoint, [
            'grant_type' => 'authorization_code',
            'client_id' => getenv('SSO_CLIENT_ID'),
            'client_secret' => getenv('SSO_SECRET_ID'),
            'redirect_uri' => getenv("CORE_AUTH_CALLBACK_URL"),
            'code' => $request->code,
        ]);

        return response()->json(['data' => $response->json()]);

    }

    // public function authorization()
    // {
    //     $clientId = getenv("CLIENT_ID");
    //     $clientSecret = getenv("CLIENT_SECRET");
    //     $ssoUrl = getenv("SSO_URL");
    //     $redirectUrl = getenv("REDIRECT_URL");

    //     $authorizationUrl = sprintf("%s/s/authorization?client_id=%s&client_secret=%s", $ssoUrl, $clientId, $clientSecret);

    //     $response = Http::get($authorizationUrl);

    //     $redirectURI = sprintf(
    //         "%s/login?authorization_token=%s&callback_url=%s&client_id=%s",
    //         $ssoUrl,
    //         $response["token"],
    //         $redirectUrl,
    //         $response["verifier"]
    //     );

    //     return response()->json(['redirect_url' => $redirectURI]);
    // }

    // public function confirmation(Request $request)
    // {
    //     $clientId = getenv('CLIENT_ID');
    //     $clientSecret = getenv('CLIENT_SECRET');

    //     $ssoUrl = getenv('SSO_URL');

    //     $confirmationUrl = sprintf('%s/s/confirm_token?client_id=%s&client_secret=%s&token=%s', $ssoUrl, $clientId, $clientSecret, $request->query('token'));

    //     $response = Http::get($confirmationUrl);

    //     return response()->json($response);
    // }
}

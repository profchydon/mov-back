<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class DecryptBearerToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (empty($request->bearerToken())) {
                throw new \Exception('No bearer token provided');
            }

            $token = $request->bearerToken();

            if (! config('app.encrypt_enabled')) {
                $request->headers->set('Authorization', "Bearer {$token}");
                return $next($request);
            }

            $decryptedToken = Crypt::decryptString($token);
            $request->headers->set('Authorization', "Bearer {$decryptedToken}");

            return $next($request);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());

            return response($ex->getMessage(), 403);
        }
    }
}

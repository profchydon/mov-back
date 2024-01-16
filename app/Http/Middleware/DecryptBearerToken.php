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
            $decryptedToken = Crypt::decryptString($request->bearerToken());
            $request->headers->set('Authorization', "Bearer {$decryptedToken}");

            return $next($request);
        } catch (DecryptException $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());

            return response('Failed to descrypt');
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 403);
        }
    }
}

<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class DecryptPayload
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Content-type', 'text/plain');

        try {
            $content = $request->getContent();

            if (empty($content)) {
                return $next($request);
            }

            if (! config('app.encrypt_enabled')) {
                $requestData = json_decode($content, true);
                if (is_array($requestData)) {
                    $request->headers->set('Content-Type', 'application/json');
                    $request->replace($requestData);
                }
                return $next($request);
            }

            $decryptedData = Crypt::decryptString($content);

            $requestData = json_decode($decryptedData, true);

            if (is_null($requestData)) {
                return $next($request);
            }

            $request->headers->set('Content-Type', 'application/json');
            $request->replace($requestData);

            return $next($request);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());

            $request->headers->set('Content-Type', 'application/json');

            return $this->error(Response::HTTP_PRECONDITION_FAILED, $exception->getMessage());
        }
    }
}

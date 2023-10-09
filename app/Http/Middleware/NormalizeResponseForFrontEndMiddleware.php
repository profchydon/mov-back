<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class NormalizeResponseForFrontEndMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (method_exists($response, 'getData')) {
            $responseInCamelCase = $this->keysToCamelCase($response->getData(true));

            return $response->setData($responseInCamelCase);
        }

        return $response;
    }

    private function keysToCamelCase($data)
    {
        if (!(is_array($data) || is_object($data))) {
            return $data;
        }
        $result = [];
        foreach ((array) $data as $key => $value) {
            $newKey = Str::camel($key);
            $result[$newKey] = $this->keysToCamelCase($value); // Recursively convert nested arrays
        }

        return $result;
    }
}

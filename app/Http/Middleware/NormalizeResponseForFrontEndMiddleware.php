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

        $responseInCamelCase = $this->keysToCamelCase($response->getData(true));

        return $response->setData($responseInCamelCase);
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

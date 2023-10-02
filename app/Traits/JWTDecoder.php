<?php

namespace App\Traits;

trait JWTDecoder
{

    /**
     * @param string $token
     * @return object
     */
    public function getHeader($token)
    {

        $tokenParts = explode(".", $token);
        $tokenHeader = base64_decode($tokenParts[0]);
        return $tokenHeader;

    }

     /**
     * @param string $token
     * @return object
     */
    public function getPayload($token)
    {

        $tokenParts = explode(".", $token);
        $jwtPayload = base64_decode($tokenParts[1]);
        return $jwtPayload;

    }

}

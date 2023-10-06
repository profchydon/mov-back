<?php

namespace App\Common;

use App\Traits\JWTDecoder;

class JWTHandler
{
    use JWTDecoder;

    /**
     * JWTHandler constructor.
     * @param object $token
     */
    public function __construct(private readonly object $token)
    {
    }

    public function getToken(): object
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->token->access_token;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->token->refresh_token;
    }

    /**
     * @return string
     */
    public function getAccessTokenHeader()
    {
        return $this->getHeader($this->token->access_token);
    }

    /**
     * @return object
     */
    public function getAccessTokenPayload()
    {
        $payload = $this->getPayload($this->token->access_token);

        return json_decode((string) $payload, true);
    }

    /**
     * @return string
     */
    public function getAccessTokenSubject()
    {
        $payload = $this->getPayload($this->token->access_token);
        $decodedPayload = json_decode((string) $payload, true);

        return $decodedPayload['sub'];
    }
}

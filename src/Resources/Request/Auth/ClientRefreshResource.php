<?php

namespace AssurConnect\Api\Resources\Request\Auth;

use AssurConnect\Api\Resources\Request\BaseResource;
use AssurConnect\Api\Resources\Response\Auth\TokenResource as TokenResponseResource;

class ClientRefreshResource extends BaseResource
{
    public string $clientId;
    public string $clientSecret;
    public string $refreshToken;
    public string $grantType;

    public function __construct(ClientResource $clientRequestResource, TokenResponseResource $tokenResponseResource)
    {
        $this->clientId = $clientRequestResource->clientId;
        $this->clientSecret = $clientRequestResource->clientSecret;
        $this->refreshToken = $tokenResponseResource->refresh;
        $this->grantType = 'refresh_token';
    }

    public function prepare(): array
    {
        return [
            'grant_type' => $this->grantType,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $this->refreshToken,
        ];
    }
}

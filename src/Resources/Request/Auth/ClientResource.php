<?php

namespace AssurConnect\Api\Resources\Request\Auth;

use AssurConnect\Api\Resources\Request\BaseResource;

class ClientResource extends BaseResource
{
    public string $clientId;
    public string $clientSecret;
    public string $username;
    public string $password;
    public string $scopes;
    public string $grantType;

    public function __construct(string $clientId, string $clientSecret, string $username, string $password, $scopes = null, string $grantType = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;

        $this->scopes = ($scopes === null ? 'user' : (is_array($scopes) ? implode(' ', $scopes) : $scopes));
        $this->grantType = ($grantType === null ? 'password' : $grantType);
    }

    public function prepare(): array
    {
        return [
            'grant_type' => $this->grantType,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->username,
            'password' => $this->password,
            'scopes' => $this->scopes,
        ];
    }
}

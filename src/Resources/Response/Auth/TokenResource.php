<?php

namespace AssurConnect\Api\Resources\Response\Auth;

use AssurConnect\Api\Resources\Response\BaseResource;

class TokenResource extends BaseResource
{
    public string $type;
    public string $access;
    public string $refresh;
    public int $expiresAt;

    public function bindTokenType($value)
    {
        $this->type = $value;
    }

    public function bindAccessToken($value)
    {
        $this->access = $value;
    }

    public function bindRefreshToken($value)
    {
        $this->refresh = $value;
    }

    public function bindExpiresIn($value)
    {
        $this->expiresAt = time() + $value - 30;
    }
}

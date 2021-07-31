<?php

namespace AssurConnect\Api\Endpoints\Auth;

use AssurConnect\Api\Endpoints\EndpointAbstract;
use AssurConnect\Api\Resources\Response\Auth\TokenResource;

class RefreshEndpoint extends EndpointAbstract
{
    protected string $endpoint = '/oauth/token';

    protected bool $encodeBodyJson = false;

    protected string $resourceResponseClass = TokenResource::class;
}

<?php

namespace AssurConnect\Api\Endpoints\Besafe\Subscription;

use AssurConnect\Api\Endpoints\EndpointAbstract;
use AssurConnect\Api\Resources\Response\Besafe\SubscriptionResource;

class CreateEndpoint extends EndpointAbstract
{
    protected string $endpoint = '/subscribe/besafe';

    protected string $resourceResponseClass = SubscriptionResource::class;
}

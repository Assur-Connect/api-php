<?php

namespace AssurConnect\Api\Endpoints\Besafe\Subscription;

use AssurConnect\Api\Endpoints\EndpointAbstract;
use AssurConnect\Api\Resources\Response\Besafe\SubscriptionResource;

class CheckEndpoint extends EndpointAbstract
{
    protected string $endpoint = '/subscribe/besafe/check';

    protected string $resourceResponseClass = SubscriptionResource::class;
}

<?php

namespace AssurConnect\Api\Endpoints\Besafe;

use AssurConnect\Api\Endpoints\EndpointAbstract;
use AssurConnect\Api\Resources\Response\Besafe\PricingResource;

class PricingEndpoint extends EndpointAbstract
{
    protected string $endpoint = '/product/besafe/pricing';

    protected string $resourceResponseClass = PricingResource::class;
}

<?php

namespace AssurConnect\Api\Endpoints\Besafe;

use AssurConnect\Api\Endpoints\EndpointAbstract;
use AssurConnect\Api\Resources\Response\Besafe\DescriptionResource;

class DescriptionEndpoint extends EndpointAbstract
{
    protected string $endpoint = '/product/besafe/description';

    protected string $callMethod = self::HTTP_READ;

    protected string $resourceResponseClass = DescriptionResource::class;
}

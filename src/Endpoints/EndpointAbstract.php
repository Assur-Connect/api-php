<?php

namespace AssurConnect\Api\Endpoints;

use AssurConnect\Api\AssurConnectApi;
use AssurConnect\Api\Exceptions\ApiException;
use AssurConnect\Api\Resources\Request\BaseResource as RequestResource;
use AssurConnect\Api\Resources\Response\BaseResource as ResponseResource;

abstract class EndpointAbstract
{
    /**
     * HTTP Methods.
     */
    public const HTTP_READ = "GET";
    public const HTTP_SEND = "POST";

    protected AssurConnectApi $api;

    protected string $endpoint;

    protected bool $encodeBodyJson = true;

    protected string $resourceResponseClass;

    protected string $callMethod = self::HTTP_SEND;

    public function __construct(AssurConnectApi $api)
    {
        $this->api = $api;
    }

    public function call(RequestResource $resourceRequest = null)
    {
        if ($this->callMethod === self::HTTP_SEND) {
            if ($resourceRequest->validate()) {
                return $this->send($resourceRequest->prepare());
            }
        } elseif ($this->callMethod === self::HTTP_READ) {
            return $this->read();
        }

        return false;
    }

    protected function send(array $body): ResponseResource
    {
        $result = $this->api->httpCall(
            self::HTTP_SEND,
            $this->endpoint,
            $this->parseRequestBody($body),
            $this->encodeBodyJson
        );

        return ResponseResource::hydrate($result, $this->resourceResponseClass);
    }

    protected function read(): ResponseResource
    {
        $result = $this->api->httpCall(
            self::HTTP_READ,
            $this->endpoint,
            null,
            $this->encodeBodyJson
        );

        return ResponseResource::hydrate($result, $this->resourceResponseClass);
    }

    protected function parseRequestBody(array $body)
    {
        if (empty($body)) {
            return null;
        }

        if ($this->encodeBodyJson === false) {
            return $body;
        }

        try {
            $encoded = @json_encode($body);
        } catch (\InvalidArgumentException $e) {
            throw new ApiException('Error encoding request body into JSON: ' . $e->getMessage() . '.', 412);
        }

        return $encoded;
    }
}

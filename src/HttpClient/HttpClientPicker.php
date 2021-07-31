<?php

namespace AssurConnect\Api\HttpClient;

use AssurConnect\Api\Exceptions\ApiException;

class HttpClientPicker
{
    public static function pickHttpClient(\AssurConnect\Api\HttpClient\HttpClientInterface $httpClient = null): \AssurConnect\Api\HttpClient\HttpClientInterface
    {
        if (!$httpClient) {
            return new HttpClientCurl();
        }

        if ($httpClient instanceof HttpClientInterface) {
            return $httpClient;
        }

        throw new ApiException('The provided HTTP client is not supported.', 404);
    }
}

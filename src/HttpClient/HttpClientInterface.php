<?php

namespace AssurConnect\Api\HttpClient;

interface HttpClientInterface
{
    /**
     * Information of the HTTP client.
     */
    public function clientInformation(): string;

    /**
     * SSL verification desactivation.
     */
    public function desactivateSslVerification(): void;

    /**
     * Send a request to the API URL.
     */
    public function send(string $method, string $url, array $headers, $body);
}

<?php

namespace AssurConnect\Api;

use AssurConnect\Api\Exceptions\ApiException;
use AssurConnect\Api\HttpClient\HttpClientPicker;
use AssurConnect\Api\Resources\Response\Auth\TokenResource;

class AssurConnectApi
{
    public const CLIENT_VERSION = '1.0.0';

    public const API_ENDPOINTS = [
        'live' => 'https://api.assur-connect.io',
        'sandbox' => 'https://sandbox.api.assur-connect.io',
    ];

    protected string $apiEndpoint;

    protected array $clientInformation = [];

    protected string $environment = 'live';

    protected \AssurConnect\Api\HttpClient\HttpClientInterface $httpClient;

    protected TokenResource $token;

    public function __construct(\AssurConnect\Api\HttpClient\HttpClientInterface $httpClient = null)
    {
        $this->httpClient = HttpClientPicker::pickHttpClient($httpClient);

        $this->setApiEndpoint($this->environment);

        $this->addClientInformation('AssurConnect/' . self::CLIENT_VERSION);
        $this->addClientInformation('PHP/' . phpversion());
        $this->addClientInformation($this->httpClient->clientInformation());
    }

    public function __get(string $endpoint): \AssurConnect\Api\Endpoints\EndpointAbstract
    {
        $endpointClass = implode('\\', preg_split('/(?=[A-Z])/', $endpoint));
        $endpointClassNamespace = '\\AssurConnect\\Api\\Endpoints\\' . ucfirst($endpointClass) . 'Endpoint';

        if (!class_exists($endpointClassNamespace)) {
            throw new ApiException('The requested endpoint ' . $endpoint . ' was not found.', 404);
        }

        return new $endpointClassNamespace($this);
    }

    public function useSandbox(bool $activate = true): void
    {
        if ($activate) {
            $this->setApiEndpoint('sandbox');
        } else {
            $this->setApiEndpoint('live');
        }
    }

    protected function setApiEndpoint(string $environment): void
    {
        if (!array_key_exists($environment, self::API_ENDPOINTS)) {
            throw new ApiException('The environment ' . $environment . ' was not found.', 404);
        }

        $this->apiEndpoint = self::API_ENDPOINTS[$environment];
    }

    public function addClientInformation(string $clientInformation): void
    {
        $this->clientInformation[] = str_replace(["\t", "\n", "\r"], '-', $clientInformation);
    }

    public function setToken(TokenResource $token): void
    {
        $this->token = $token;
    }

    public function httpCall(string $method, string $endpoint, $body = null, bool $encodeBodyJson = true): array
    {
        $url = $this->apiEndpoint . $endpoint;

        $headers = [
            'User-Agent' => implode(' ', $this->clientInformation),
            'Accept' => 'application/json',
        ];

        if ($encodeBodyJson && $this->token !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->token->access;
            $headers['Content-Type'] = 'application/json';
        }

        if (function_exists('php_uname')) {
            $headers['X-AssurConnect-Client-OS'] = php_uname();
        }

        return $this->httpClient->send($method, $url, $headers, $body);
    }
}

<?php

namespace AssurConnect\Api\HttpClient;

use Composer\CaBundle\CaBundle;
use AssurConnect\Api\Exceptions\ApiException;
use AssurConnect\Api\Endpoints\EndpointAbstract;

final class HttpClientCurl implements HttpClientInterface
{
    /**
     * Connection timeout in seconds.
     */
    public const CONNECTION_TIMEOUT = 2;

    /**
     * Response timeout in seconds.
     */
    public const RESPONSE_TIMEOUT = 10;

    protected $sslVerification = true;

    public function clientInformation(): string
    {
        $curlVersion = \curl_version();

        return 'cURL/' . (isset($curlVersion['version']) ? $curlVersion['version'] : '*') . (isset($curlVersion['ssl_version']) ? ' ' . $curlVersion['ssl_version'] : '');
    }

    public function desactivateSslVerification(): void
    {
        $this->sslVerification = false;
    }

    public function send(string $method, string $url, array $headers, $body)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->generateHeaders($headers));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::CONNECTION_TIMEOUT);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::RESPONSE_TIMEOUT);
        if (!$this->sslVerification) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        } else {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_CAINFO, CaBundle::getBundledCaBundlePath());
        }

        switch ($method) {
            case EndpointAbstract::HTTP_SEND:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
                break;
            case EndpointAbstract::HTTP_READ:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                break;
            default:
                throw new ApiException('Invalid HTTP method: ' . $method, 405);
        }

        $response = curl_exec($curl);

        if ($response === false) {
            throw new ApiException('cURL error: ' . curl_error($curl), 400);
        }

        $statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        curl_close($curl);

        return $this->processResponse($statusCode, $response, $body);
    }

    protected function generateHeaders(array $headers): array
    {
        $result = [];

        foreach ($headers as $key => $value) {
            $result[] = $key . ': ' . $value;
        }

        return $result;
    }

    protected function processResponse(int $statusCode, string $response, $body = null)
    {
        $response = @json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException('Unable to decode API response: ' . print_r($response, true) . '.', 412);
        }

        if ($statusCode > 202 || isset($response['error']) || isset($response['message'])) {
            throw new ApiException('', $statusCode, $body, $response);
        }

        return $response;
    }
}

<?php

namespace AssurConnect\Api\Exceptions;

class ApiException extends \Exception
{
    private $body = null;
    private $response = null;

    public function __construct(
        string $messageSource = '',
        int $code = 0,
        $requestBody = null,
        $response = null
    ) {
        $this->code = $code;

        $message = '[' . (new \DateTimeImmutable())->format(\DateTime::ISO8601) . '] ' . 'Error Code: ' . $code;

        if ($messageSource !== '') {
            $message .= PHP_EOL . $messageSource;
        }

        if ($requestBody) {
            $this->body = $requestBody;
            $message .= PHP_EOL . 'Request body: ' . print_r($requestBody, true);
        }

        if (!empty($response)) {
            $this->response = $response;
            $message .= PHP_EOL . 'Response body: ' . print_r($response, true);
        }

        parent::__construct($message, $code);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getResponse()
    {
        return $this->response;
    }
}

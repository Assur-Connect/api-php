<?php

namespace AssurConnect\Api\Exceptions;

class ApiException extends \Exception
{
    public function __construct(
        string $messageSource = '',
        int $code = 0,
        $requestBody = null,
        $response = null
    ) {
        $message = '[' . (new \DateTimeImmutable())->format(\DateTime::ISO8601) . '] ' . 'Error Code: ' . $code;

        if ($messageSource !== '') {
            $message .= PHP_EOL . $messageSource;
        }

        if ($requestBody) {
            $message .= PHP_EOL . 'Request body: ' . print_r($requestBody, true);
        }

        if (!empty($response)) {
            $message .= PHP_EOL . 'Response body: ' . print_r($response, true);
        }

        parent::__construct($message, $code);
    }
}

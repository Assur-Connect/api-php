# Assur Connect API client library for PHP

Integrate Assur Connect insurance solutions in your PHP application(s) using the API.

## Requirements

- Request a [partner Assur Connect account](https://www.assur-connect.com)
- PHP >= 7.4 and later
- Up-to-date OpenSSL (or other SSL/TLS toolkit)

## Installation via Composer

To install the package via [Composer](http://getcomposer.org/), run the following command:

```bash
composer require assur-connect/api-php
```

To use the package, use [Composer's autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Dependencies

The package requires the following extensions in order to work properly:

-   [`curl`](https://secure.php.net/manual/en/book.curl.php)
-   [`json`](https://secure.php.net/manual/en/book.json.php)
-   [`openssl`](https://secure.php.net/manual/en/book.openssl.php)

## Getting Started


```php

// API initialization using Sandbox environment.
$api = new \AssurConnect\Api\AssurConnectApi;
$api->useSandbox();

// Authentication.
$clientRequestResource = new \AssurConnect\Api\Resources\Request\Auth\ClientResource(
    '9a250da6d-6209-4f91-8b69-1682976a7404',
    'test_c7c1d293-7a0b-45b5-8416-b9cff99270da',
    'TEST',
    '92284041-cca2-453c-a488-bfbc42a8a559',
);

$token = $api->authToken->call($clientRequestResource);
$api->setToken($token);

// Pricing for BeSafe insurance product.
$pricingRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\PricingResource;
$pricingRequestResource->setDuration(1, 'day');
$pricingRequestResource->setBeneficiariesCount(2);
$pricingRequestResource->addActivity('VTT');

$pricing = $api->besafePricing->call($pricingRequestResource);
```

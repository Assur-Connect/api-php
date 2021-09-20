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

// API initialization.
$api = new \AssurConnect\Api\AssurConnectApi;

// Use Sandbox environment.
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

// Change language.
// $api->setLanguage('fr');

// Get Pricing for BeSafe insurance product.
$pricingRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\PricingResource;
$pricingRequestResource->setDuration(1, 'day');
$pricingRequestResource->setBeneficiariesCount(2);
$pricingRequestResource->addActivity('VTT');

$pricingResponseResource = $api->besafePricing->call($pricingRequestResource);

var_dump($pricingResponseResource);
/*
object(AssurConnect\Api\Resources\Response\Besafe\PricingResource)#8 (2) {
  ["price"]=> float(4)
  ["currency"]=> string(3) "EUR"
}
*/

// Check Subscription information for BeSafe insurance product.
$subscriberEntity = new \AssurConnect\Api\Resources\Request\Besafe\Entities\SubscriberEntity();
$subscriberEntity->setLastname('Eiffel');
$subscriberEntity->setFirstname('Tower');
$subscriberEntity->setAddress('Champ de Mars');
$subscriberEntity->setAdditionalAddress('5 avenue Anatole France');
$subscriberEntity->setZipCode('75007');
$subscriberEntity->setCity('Paris');
$subscriberEntity->setBirthdate('1989-03-31');
$subscriberEntity->setEmail('eiffel.tower@paris.city');
$subscriberEntity->setPhone('0892701239');

$subscriptionRequestResource = \AssurConnect\Api\Resources\Request\Besafe\SubscriptionResource::createFromPricingRequestResource($pricingRequestResource, $pricingResponseResource);
$subscriptionRequestResource->setSubscriber($subscriberEntity);
$subscriptionRequestResource->addBeneficiaryFromSubscriber();
$subscriptionRequestResource->addBeneficiary(
    'Triomphe',    // lastname
    'Arc',         // firstname
    '1986-07-29'   // birthDate
);
$subscriptionRequestResource->setEffectiveDate(new DateTime());
// $subscriptionRequestResource->setTransactionReference('TEST_000001');

$subscriptionCheckResponseResource = $api->besafeSubscriptionCheck->call($subscriptionRequestResource);

var_dump($subscriptionCheckResponseResource);
/*
object(AssurConnect\Api\Resources\Response\Besafe\SubscriptionResource)#11 (1) {
  ["confirmation"]=>
  string(23) "Check Integrity Data OK"
}
*/

// Create Subscription information for BeSafe insurance product (be sure to have a valid payment before).
$subscriptionResponseResource = $api->besafeSubscriptionCreate->call($subscriptionRequestResource);

var_dump($subscriptionResponseResource);
/*
object(AssurConnect\Api\Resources\Response\Besafe\SubscriptionResource)#11 (1) {
  ["confirmation"]=>
  string(19) "Subscription saved."
}
*/
```

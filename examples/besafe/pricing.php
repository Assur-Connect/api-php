<?php

try {
    require '../initialization.php';

    $pricingRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\PricingResource();
    $pricingRequestResource->addActivity('VTT');
    $pricingRequestResource->setBeneficiariesCount(2);

    $pricingResponseResource = $api->besafePricing->call($pricingRequestResource);

    var_dump($pricingResponseResource);
} catch (\AssurConnect\Api\Exceptions\ApiException $e) {
    echo htmlspecialchars($e->getMessage()) . PHP_EOL;
}

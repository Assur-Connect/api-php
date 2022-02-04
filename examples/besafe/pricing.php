<?php

try {
    require '../initialization.php';

    $activityCode = 'VTT';
    $discountCode = null;

    $pricingRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\PricingResource();
    $pricingRequestResource->addActivity($activityCode);
    $pricingRequestResource->setBeneficiariesCount(2);

    if ($discountCode !== null) {
        $pricingRequestResource->setDiscountCode($discountCode);
    }

    $pricingResponseResource = $api->besafePricing->call($pricingRequestResource);

    var_dump($pricingResponseResource);
} catch (\AssurConnect\Api\Exceptions\ApiException $e) {
    echo htmlspecialchars($e->getMessage()) . PHP_EOL;
}

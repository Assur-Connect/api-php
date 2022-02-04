<?php

try {
    require '../initialization.php';

    $activityCode = 'VTT';
    $discountCode = null;

    // Pricing request.
    $pricingRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\PricingResource();
    $pricingRequestResource->addActivity($activityCode);
    $pricingRequestResource->setBeneficiariesCount(1);

    if ($discountCode !== null) {
        $pricingRequestResource->setDiscountCode($discountCode);
    }

    $pricingResponseResource = $api->besafePricing->call($pricingRequestResource);

    var_dump($pricingResponseResource);

    // Subscriber filling.
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

    // Subscription creation request.
    $subscriptionRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\SubscriptionResource();
    $subscriptionRequestResource->setSubscriber($subscriberEntity);
    $subscriptionRequestResource->addBeneficiaryFromSubscriber();
    $subscriptionRequestResource->addActivity($activityCode);
    $subscriptionRequestResource->setEffectiveDate(new DateTime());
    $subscriptionRequestResource->setPricing($pricingResponseResource->price, $pricingResponseResource->currency);
    $subscriptionRequestResource->setTransactionReference('TEST_000001');

    if ($discountCode !== null) {
        $subscriptionRequestResource->setDiscountCode($discountCode);
    }

    $subscriptionResponseResource = $api->besafeSubscriptionCreate->call($subscriptionRequestResource);

    var_dump($subscriptionResponseResource);
} catch (\AssurConnect\Api\Exceptions\ApiException $e) {
    echo htmlspecialchars($e->getMessage()) . PHP_EOL;
}

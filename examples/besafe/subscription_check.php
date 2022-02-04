<?php

try {
    require '../initialization.php';

    $activityCode = 'VTT';
    $discountCode = null;

    // Pricing request.
    $pricingRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\PricingResource();
    $pricingRequestResource->addActivity($activityCode);
    $pricingRequestResource->setBeneficiariesCount(2);

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

    // Subscription Check request.
    $subscriptionRequestResource = new \AssurConnect\Api\Resources\Request\Besafe\SubscriptionResource();
    $subscriptionRequestResource->setSubscriber($subscriberEntity);
    $subscriptionRequestResource->addBeneficiaryFromSubscriber();
    $subscriptionRequestResource->addBeneficiary(
        'Triomphe',
        'Arc',
        '1986-07-29'
    );
    $subscriptionRequestResource->addActivity($activityCode);
    $subscriptionRequestResource->setEffectiveDate(new DateTime());
    $subscriptionRequestResource->setPricing($pricingResponseResource->price, $pricingResponseResource->currency);

    if ($discountCode !== null) {
        $subscriptionRequestResource->setDiscountCode($discountCode);
    }

    $subscriptionCheckResponseResource = $api->besafeSubscriptionCheck->call($subscriptionRequestResource);

    var_dump($subscriptionCheckResponseResource);
} catch (\AssurConnect\Api\Exceptions\ApiException $e) {
    echo htmlspecialchars($e->getMessage()) . PHP_EOL;
}

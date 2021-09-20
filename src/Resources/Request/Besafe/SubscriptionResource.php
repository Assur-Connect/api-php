<?php

namespace AssurConnect\Api\Resources\Request\Besafe;

use AssurConnect\Api\Resources\Request\Besafe\Entities\SubscriberEntity;
use AssurConnect\Api\Resources\Request\Besafe\PricingResource as PricingRequestResource;
use AssurConnect\Api\Resources\Response\Besafe\PricingResource as PricingResponseResource;
use DateTime;

class SubscriptionResource extends BesafeResource
{
    protected SubscriberEntity $subscriber;
    protected string $effectiveDate;
    protected array $beneficiaries = [];
    protected array $transaction = [
        'amount' => 0,
        'currency' => 'EUR',
        'reference' => '',
        'timestamp' => 0,
    ];

    public function validate(): bool
    {
        return $this->validateCoverage($this->coverage)
            && $this->validateDurationUnit($this->durationUnit)
            && $this->validateActivities($this->activities)
            && $this->validateBeneficiaries($this->beneficiaries);
    }

    public function prepare(): array
    {
        return [
            'subscriber' => $this->subscriber->prepare(),
            'product' => [
                'coverage' => [
                    'code' => $this->coverage,
                    'duration' => $this->duration,
                    'duration_unit' => $this->durationUnit,
                ],
                'effective_date' => $this->effectiveDate,
                'dpia_check' => true,
            ],
            'activities' => $this->activities,
            'beneficiaries' => $this->beneficiaries,
            'transaction' => [
                'amount' => $this->transaction['amount'],
                'currency' => $this->transaction['currency'],
                'transaction_date' => ($this->transaction['timestamp'] !== 0 ? $this->transaction['timestamp'] : time()),
                'transaction_number' => ($this->transaction['reference'] !== '' ? $this->transaction['reference'] : bin2hex(random_bytes(rand(1, 10)))),
            ],
        ];
    }

    public static function createFromPricingRequestResource(PricingRequestResource $pricingRequestResource, PricingResponseResource $pricingResponseResource): SubscriptionResource
    {
        $resource = new self();
        $resource->coverage = $pricingRequestResource->coverage;
        $resource->duration = $pricingRequestResource->duration;
        $resource->durationUnit = $pricingRequestResource->durationUnit;
        $resource->activities = $pricingRequestResource->activities;

        $resource->transaction['amount'] = $pricingResponseResource->price;
        $resource->transaction['currency'] = $pricingResponseResource->currency;

        return $resource;
    }

    public function setSubscriber(subscriberEntity $subscriber): void
    {
        $this->subscriber = $subscriber;
    }

    public function setEffectiveDate(DateTime $effectiveDate): void
    {
        $this->effectiveDate = $effectiveDate->format('Y-m-d');
    }

    public function setEffectiveDateFromString(string $effectiveDate): void
    {
        $this->effectiveDate = $effectiveDate;
    }

    public function setCoverage(string $coverage): void
    {
        $this->coverage = $coverage;
    }

    public function setDuration(int $duration = 1, string $durationUnit = 'day'): void
    {
        $this->duration = $duration;
        $this->durationUnit = $durationUnit;
    }

    public function addActivity(string $activity): void
    {
        $this->activities[] = $activity;
    }

    public function addBeneficiary(string $lastname, string $firstname, string $birthDate): void
    {
        $this->beneficiaries[] = [
            'lastname' => $lastname,
            'firstname' => $firstname,
            'date_of_birth' => $birthDate,
        ];
    }

    public function addBeneficiaryFromSubscriber(): void
    {
        $this->beneficiaries[] = [
            'lastname' => $this->subscriber->getLastname(),
            'firstname' => $this->subscriber->getFirstname(),
            'date_of_birth' => $this->subscriber->getBirthDate(),
        ];
    }

    public function setPricing(float $price, string $currency = null): void
    {
        $this->transaction['amount'] = $price;

        if ($currency !== null) {
            $this->transaction['currency'] = $currency;
        }
    }

    public function setTransactionReference(string $reference): void
    {
        $this->transaction['reference'] = $reference;
    }

    public function setTransactionTimestamp(int $timestamp): void
    {
        $this->transaction['timestamp'] = $timestamp;
    }
}

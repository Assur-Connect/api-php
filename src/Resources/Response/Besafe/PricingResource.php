<?php

namespace AssurConnect\Api\Resources\Response\Besafe;

use AssurConnect\Api\Resources\Response\BaseResource;

class PricingResource extends BaseResource
{
    public float $price;
    public string $currency;

    public function bindPublicPremium($value)
    {
        $this->price = $value;
    }
}

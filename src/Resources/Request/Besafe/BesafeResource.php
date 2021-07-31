<?php

namespace AssurConnect\Api\Resources\Request\Besafe;

use AssurConnect\Api\Exceptions\ApiException;
use AssurConnect\Api\Resources\Request\BaseResource;

class BesafeResource extends BaseResource
{
    protected string $coverage = 'basic';
    protected array $activities = [];
    protected int $duration = 1;
    protected string $durationUnit = 'day';
    protected int $beneficiariesCount = 1;

    protected array $coverageList = [
        'basic',
        'premium',
    ];

    protected array $durationUnitList = [
        'day',
        'weekend',
        'week',
        'year',
    ];

    protected function validateCoverage($coverage)
    {
        if (!in_array($coverage, $this->coverageList)) {
            throw new ApiException('This coverage ' . $coverage . ' is not supported', 400);
        }

        return true;
    }

    protected function validateDurationUnit($durationUnit)
    {
        if (!in_array($durationUnit, $this->durationUnitList)) {
            throw new ApiException('This durationn unit ' . $durationUnit . ' is not supported', 400);
        }

        return true;
    }

    protected function validateActivities($activities)
    {
        if (!is_array($activities)) {
            throw new ApiException('Invalid activities format: ' . print_r($activities, true), 400);
        }

        if (count($activities) < 1) {
            throw new ApiException('At least 1 activity is needed.', 412);
        }

        return true;
    }

    protected function validateBeneficiaries($beneficiaries)
    {
        if (!is_array($beneficiaries)) {
            throw new ApiException('Invalid beneficiaries format: ' . print_r($beneficiaries, true));
        }

        if (count($beneficiaries) < 1) {
            throw new ApiException('At least 1 beneficiary is needed.', 412);
        }

        return true;
    }
}

<?php

namespace AssurConnect\Api\Resources\Request\Besafe;

class PricingResource extends BesafeResource
{
    public function validate(): bool
    {
        return $this->validateCoverage($this->coverage)
            && $this->validateDurationUnit($this->durationUnit)
            && $this->validateActivities($this->activities);
    }

    public function prepare(): array
    {
        return [
            'coverage_code' => $this->coverage,
            'activities' => $this->activities,
            'duration' => $this->duration,
            'duration_unit' => $this->durationUnit,
            'beneficiaries_count' => $this->beneficiariesCount,
        ];
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

    public function addActivity(string $activity)
    {
        $this->activities[] = $activity;
    }

    public function setBeneficiariesCount(int $beneficiariesCount): void
    {
        $this->beneficiariesCount = $beneficiariesCount;
    }
}

<?php

namespace App\Events;

use App\Models\Order\PlanType;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PlanSelected extends ShouldBeStored
{
    public function __construct(
        private readonly int $planTypeValue,
        private readonly int $planId,
        private readonly int $companyId,
    ) {
    }

    public function getPlanTypeValue(): int
    {
        return $this->planTypeValue;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getPlanId(): int
    {
        return $this->planId;
    }
}

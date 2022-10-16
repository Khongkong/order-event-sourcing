<?php

namespace App\Events;

use App\Models\Order\PlanType;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PlanSelected extends ShouldBeStored
{
    public function __construct(
        private PlanType $planType,
        private int $planId,
        private int $companyId,
    ) {
    }
}

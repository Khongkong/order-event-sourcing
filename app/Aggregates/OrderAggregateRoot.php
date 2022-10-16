<?php

namespace App\Aggregates;

use App\Events\OrderCreated;
use App\Events\PlanSelected;
use App\Models\Order\PlanType;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregateRoot extends AggregateRoot
{
    public function createOrder(int $companyId): self
    {
        $this->recordThat(new OrderCreated($companyId));
        return $this;
    }

    public function selectPlan(
        PlanType $planType,
        int $planId,
        int $companyId
    ): self {
        $this->recordThat(new PlanSelected($planType, $planId, $companyId));
        return $this;
    }
}

<?php

namespace App\Aggregates;

use App\Events\JobsReserved;
use App\Events\OrderConfirmed;
use App\Events\OrderCreated;
use App\Events\PlanSelected;
use App\Events\StartDateSelected;
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
        int $planTypeValue,
        int $planId,
        int $companyId
    ): self {
        $this->recordThat(new PlanSelected($planTypeValue, $planId, $companyId));
        return $this;
    }

    public function selectStartDate(int $startedAt, int $companyId): self
    {
        $this->recordThat(new StartDateSelected($startedAt, $companyId));
        return $this;
    }

    public function reserveJobs(int $orderId, array $jobIds, int $companyId): self
    {
        $this->recordThat(new JobsReserved($orderId, $jobIds, $companyId));
        return $this;
    }

    public function confirmOrder(int $companyId): self
    {
        $this->recordThat(new OrderConfirmed($companyId));
        return $this;
    }
}

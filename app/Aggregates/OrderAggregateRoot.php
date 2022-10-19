<?php

namespace App\Aggregates;

use App\Events\FirstStepLimitHit;
use App\Events\JobsReserved;
use App\Events\OrderConfirmed;
use App\Events\OrderInitiated;
use App\Events\PlanSelected;
use App\Events\StartDateSelected;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregateRoot extends AggregateRoot
{
    private int $enterFirstStepCount = 0;

    public function initiateOrder(int $companyId): self
    {
        if ($this->hasEnteredFirstStepTooManyTimes()) {
            $this->recordThat(new FirstStepLimitHit($companyId));
            $this->persist();
        }

        $this->recordThat(new OrderInitiated($companyId));
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

    public function applyOrderInitiated(OrderInitiated $event): void
    {
        $this->enterFirstStepCount++;
    }

    public function getEnterFirstStepCount(): int
    {
        return $this->enterFirstStepCount;
    }

    private function hasEnteredFirstStepTooManyTimes(): bool
    {
        return $this->enterFirstStepCount >= 2;
    }
}

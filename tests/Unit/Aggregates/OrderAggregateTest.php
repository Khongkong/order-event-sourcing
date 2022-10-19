<?php

namespace Tests\Unit\Aggregates;

use App\Aggregates\OrderAggregateRoot;
use App\Events\FirstStepLimitHit;
use App\Events\JobsReserved;
use App\Events\OrderConfirmed;
use App\Events\OrderInitiated;
use App\Events\PlanSelected;
use App\Events\StartDateSelected;
use App\Models\Order\PlanType;
use Tests\TestCase;

class OrderAggregateTest extends TestCase
{
    private const COMPANY_ID = 89123;
    private const PLAN_ID = 39843;
    private const ORDER_ID = 394389;

    /**
     * @test
     */
    public function shouldRecordOrderInitiatedWithNoLimitHit(): void
    {
        OrderAggregateRoot::fake()
            ->given([
                new OrderInitiated(self::COMPANY_ID),
                new FirstStepLimitHit(self::COMPANY_ID)
            ])
            ->when(function (OrderAggregateRoot $aggregateRoot) {
                $aggregateRoot->initiateOrder(self::COMPANY_ID);
            })
            ->assertRecorded(new OrderInitiated(self::COMPANY_ID))
            ->assertNotRecorded(FirstStepLimitHit::class);
    }

    /**
     * @test
     */
    public function shouldRecordPlanIsSelected(): void
    {
        OrderAggregateRoot::fake()
            ->given(new PlanSelected(PlanType::NORMAL->value, self::PLAN_ID, self::COMPANY_ID))
            ->when(function (OrderAggregateRoot $aggregateRoot): void {
                $aggregateRoot->selectPlan(PlanType::NORMAL->value, self::PLAN_ID, self::COMPANY_ID);
            })
            ->assertRecorded(new PlanSelected(PlanType::NORMAL->value, self::PLAN_ID, self::COMPANY_ID));
    }

    /**
     * @test
     */
    public function shouldRecordStartDateSelected(): void
    {
        $startedAtTimestamp = now()->addMonth()->getTimestamp();
        OrderAggregateRoot::fake()
            ->given(new StartDateSelected($startedAtTimestamp, self::COMPANY_ID))
            ->when(function (OrderAggregateRoot $aggregateRoot) use ($startedAtTimestamp): void {
                $aggregateRoot->selectStartDate($startedAtTimestamp, self::COMPANY_ID);
            })
            ->assertRecorded(new StartDateSelected($startedAtTimestamp, self::COMPANY_ID));
    }

    /**
     * @test
     */
    public function shouldRecordJobsReserved(): void
    {
        $jobIds = [1, 2, 3];
        OrderAggregateRoot::fake()
            ->given(new JobsReserved(self::ORDER_ID, $jobIds, self::COMPANY_ID))
            ->when(function (OrderAggregateRoot $aggregateRoot) use ($jobIds): void {
                $aggregateRoot->reserveJobs(self::ORDER_ID, $jobIds, self::COMPANY_ID);
            })
            ->assertRecorded(new JobsReserved(self::ORDER_ID, $jobIds, self::COMPANY_ID));
    }

    /**
     * @test
     */
    public function shouldRecordConfirmOrder(): void
    {
        OrderAggregateRoot::fake()
            ->given(new OrderConfirmed(self::COMPANY_ID))
            ->when(function (OrderAggregateRoot $aggregateRoot): void {
                $aggregateRoot->confirmOrder(self::COMPANY_ID);
            })
            ->assertRecorded(new OrderConfirmed(self::COMPANY_ID));
    }
}

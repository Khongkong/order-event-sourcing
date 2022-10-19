<?php

namespace Tests\Unit\Projectors;

use App\Events\PlanSelected;
use App\Models\NormalPlan;
use App\Models\Order\PlanType;
use App\Models\PackagePlan;
use App\Projectors\Exceptions\PlanNotFoundException;
use Mockery;
use Mockery\MockInterface;

class OnPlanSelectedTest extends OrderProjectorTest
{
    private const COMPANY_ID = 392834;
    private const UUID = '93288831-9c26-4ea5-ba48-ab8d09b09542';

    /**
     * @test
     */
    public function normalPlanSelected(): void
    {
        $planId = 123123;
        $this->normalPlanRepository
            ->expects('find')
            ->with($planId)
            ->andReturns($plan = NormalPlan::factory()->makeOne());
        $this->packagePlanRepository
            ->allows('find')
            ->never();
        $this->orderRepository
            ->expects('updateOderPlan')
            ->with(self::COMPANY_ID, $plan);
        $this->target()->onPlanSelected($this->mockPlanSelectedEvent($planId, PlanType::NORMAL));
    }

    /**
     * @test
     */
    public function packagePlanSelected(): void
    {
        $planId = 123123;
        $this->packagePlanRepository
            ->expects('find')
            ->with($planId)
            ->andReturns($plan = PackagePlan::factory()->makeOne());
        $this->normalPlanRepository
            ->allows('find')
            ->never();
        $this->orderRepository
            ->expects('updateOderPlan')
            ->with(self::COMPANY_ID, $plan);
        $this->target()->onPlanSelected($this->mockPlanSelectedEvent($planId, PlanType::PACKAGE));
    }

    public function noNormalPlanIsFound(): void
    {
        $this->expectException(PlanNotFoundException::class);
        $planId = 123123;
        $this->normalPlanRepository
            ->expects('find')
            ->with($planId)
            ->andReturnNull();
        $this->target()->onPlanSelected($this->mockPlanSelectedEvent($planId, PlanType::NORMAL));
    }

    public function noPackagePlanIsFound(): void
    {
        $this->expectException(PlanNotFoundException::class);
        $planId = 123123;
        $this->packagePlanRepository
            ->expects('find')
            ->with($planId)
            ->andReturnNull();
        $this->target()->onPlanSelected($this->mockPlanSelectedEvent($planId, PlanType::PACKAGE));
    }

    private function mockPlanSelectedEvent(int $planId, PlanType $planType): MockInterface&PlanSelected
    {
        $event = Mockery::mock(PlanSelected::class)->makePartial();
        $event->allows([
            'getCompanyId' => self::COMPANY_ID,
            'getPlanId' => $planId,
            'getPlanTypeValue' => $planType->value,
            'aggregateRootUuid' => self::UUID,
        ]);
        return $event;
    }
}

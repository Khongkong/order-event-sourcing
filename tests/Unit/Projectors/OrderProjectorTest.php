<?php

namespace Tests\Unit\Projectors;

use App\Projectors\OrderProjector;
use App\Repositories\JobRepository;
use App\Repositories\NormalPlanRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PackagePlanRepository;
use App\Repositories\ReservedJobRepository;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

abstract class OrderProjectorTest extends TestCase
{
    protected MockInterface&OrderRepository $orderRepository;
    protected MockInterface&NormalPlanRepository $normalPlanRepository;
    protected MockInterface&PackagePlanRepository $packagePlanRepository;
    protected MockInterface&JobRepository $jobRepository;
    protected MockInterface&ReservedJobRepository $reservedJobRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = Mockery::mock(OrderRepository::class);
        $this->normalPlanRepository = Mockery::mock(NormalPlanRepository::class);
        $this->packagePlanRepository = Mockery::mock(PackagePlanRepository::class);
        $this->jobRepository = Mockery::mock(JobRepository::class);
        $this->reservedJobRepository = Mockery::mock(ReservedJobRepository::class);
    }

    protected function target(): OrderProjector
    {
        return new OrderProjector(
            $this->orderRepository,
            $this->normalPlanRepository,
            $this->packagePlanRepository,
            $this->jobRepository,
            $this->reservedJobRepository
        );
    }
}

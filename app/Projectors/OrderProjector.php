<?php

namespace App\Projectors;

use App\Events\JobsReserved;
use App\Events\OrderConfirmed;
use App\Events\OrderCreated;
use App\Events\PlanSelected;
use App\Events\StartDateSelected;
use App\Models\Order;
use App\Repositories\NormalPlanRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PackagePlanRepository;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    public function __construct(
        private OrderRepository $orderRepository,
        private NormalPlanRepository $normalPlanRepository,
        private PackagePlanRepository $packagePlanRepository,
    ) {
    }

    public function onOrderCreated(OrderCreated $event): Order
    {
        return $this->orderRepository->findCurrentOrder($event->getCompanyId())
            ?? $this->orderRepository->createNewOrder($event->getCompanyId(), $event->aggregateRootUuid());
    }

    public function onPlanSelected(PlanSelected $event)
    {

    }

    public function onStartDateSelected(StartDateSelected $event)
    {
    }

    public function onJobsReserved(JobsReserved $event)
    {
    }

    public function onOrderConfirmed(OrderConfirmed $event)
    {
    }
}

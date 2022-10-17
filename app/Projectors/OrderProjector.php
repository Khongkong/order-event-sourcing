<?php

namespace App\Projectors;

use App\Events\JobsReserved;
use App\Events\OrderConfirmed;
use App\Events\OrderCreated;
use App\Events\PlanSelected;
use App\Events\StartDateSelected;
use App\Models\Order;
use App\Repositories\JobRepository;
use App\Repositories\NormalPlanRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PackagePlanRepository;
use App\Repositories\ReservedJobRepository;
use Illuminate\Support\Facades\Date;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    public function __construct(
        private OrderRepository $orderRepository,
        private NormalPlanRepository $normalPlanRepository,
        private PackagePlanRepository $packagePlanRepository,
        private JobRepository $jobRepository,
        private ReservedJobRepository $reservedJobRepository
    ) {
    }

    public function onOrderCreated(OrderCreated $event): void
    {
        if ($this->orderRepository->findCurrentOrder($event->getCompanyId()) !== null) {
            return;
        }
        $this->orderRepository->createNewOrder($event->getCompanyId(), $event->aggregateRootUuid());
    }

    public function onPlanSelected(PlanSelected $event): void
    {
        $plan = Order\PlanType::from($event->getPlanTypeValue()) === Order\PlanType::NORMAL
            ? $this->normalPlanRepository->find($event->getPlanId())
            : $this->packagePlanRepository->find($event->getPlanId());
        if ($plan === null) {
            throw new \UnexpectedValueException('Plan not found');
        }
        $this->orderRepository->updateOderPlan($event->getCompanyId(), $plan);
    }

    public function onStartDateSelected(StartDateSelected $event): void
    {
        $this->orderRepository->updateStartDate(
            $event->getCompanyId(),
            Date::createFromTimestamp($event->getStartedAtTimestamp())
        );
    }

    public function onJobsReserved(JobsReserved $event): void
    {
        $jobs = $this->jobRepository->getJobs($jobIds = $event->getJobIds());
        if ($jobs->count() !== count($jobIds)) {
            throw new \RangeException('Some jobs are not found');
        }
        if ($jobs->isNotEmpty()) {
            $this->reservedJobRepository->addReservingJobs($event->getOrderId(), $jobIds);
        }
        $this->orderRepository->updateOrderReservingJobs($event->getCompanyId());
    }

    public function onOrderConfirmed(OrderConfirmed $event): void
    {
        $this->orderRepository->confirmOrder($event->getCompanyId());
    }
}

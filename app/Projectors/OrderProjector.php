<?php

namespace App\Projectors;

use App\Events\FirstStepLimitHit;
use App\Events\JobsReserved;
use App\Events\OrderConfirmed;
use App\Events\OrderInitiated;
use App\Events\PlanSelected;
use App\Events\StartDateSelected;
use App\Models\Order;
use App\Projectors\Exceptions\PlanNotFoundException;
use App\Projectors\Exceptions\UnidentifiedJobException;
use App\Repositories\JobRepository;
use App\Repositories\NormalPlanRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PackagePlanRepository;
use App\Repositories\ReservedJobRepository;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly NormalPlanRepository $normalPlanRepository,
        private readonly PackagePlanRepository $packagePlanRepository,
        private readonly JobRepository $jobRepository,
        private readonly ReservedJobRepository $reservedJobRepository
    ) {
    }

    public function onOrderInitiated(OrderInitiated $event): void
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
            throw new PlanNotFoundException();
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
            throw new UnidentifiedJobException();
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

    public function onFirstStepLimitHit(FirstStepLimitHit $event): void
    {
        Log::info($event->getCompanyId() . ' has reached the first step limit');
    }
}

<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Order\PlanType;
use App\Models\Order\Status;
use App\Models\Plan\PlanContract;
use Illuminate\Support\Carbon;

class OrderRepository
{
    public function createNewOrder(int $companyId, string $uuid): Order
    {
        return Order::create([
            'uuid' => $uuid,
            'company_id' => $companyId,
            'plan_type' => PlanType::UNDETERMINED,
            'status' => Status::ORDER_INITIATED,
            'is_valid' => true,
            'price' => 0,
        ]);
    }

    public function findCurrentOrder(int $companyId): ?Order
    {
        return Order::where([
            'company_id' => $companyId,
            'is_valid' => true,
        ])->first();
    }

    public function updateOderPlan(int $companyId, PlanContract $plan): void
    {
        Order::query()
            ->where([
                'company_id' => $companyId,
                'is_valid' => true,
            ])
            ->update([
                'price' => $plan->getPrice(),
                'plan_type' => $plan->getPlanType(),
                'plan_id' => $plan->getId(),
                'status' => Status::PLAN_CHOSEN,
            ]);
    }

    public function updateStartDate(int $companyId, Carbon $startedAt): void
    {
        Order::query()
            ->where([
                'company_id' => $companyId,
                'is_valid' => true,
            ])
            ->update([
                'started_at' => $startedAt,
                'status' => Status::DATE_SELECTED,
            ]);
    }

    public function updateOrderReservingJobs(int $companyId): void
    {
        Order::query()
            ->where([
                'company_id' => $companyId,
                'is_valid' => true,
            ])
            ->update([
                'status' => Status::JOB_RESERVED,
            ]);
    }

    public function confirmOrder($companyId): void
    {
        Order::query()
            ->where([
                'company_id' => $companyId,
                'is_valid' => true,
            ])
            ->update([
                'status' => Status::ORDER_COMPLETED,
            ]);
    }
}

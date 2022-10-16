<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Order\PlanType;
use App\Models\Order\Status;

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
        ]);
    }

    public function findCurrentOrder(int $companyId): ?Order
    {
        return Order::where([
            'company_id' => $companyId,
            'is_valid' => true,
        ])->first();
    }
}

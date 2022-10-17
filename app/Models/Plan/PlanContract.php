<?php

namespace App\Models\Plan;

use App\Models\Order\PlanType;

/**
 * Marker interface.
 */
interface PlanContract
{
    public function getId(): int;

    public function getPrice(): int;

    public function getTerm(): int;

    public function getPlanType(): PlanType;
}

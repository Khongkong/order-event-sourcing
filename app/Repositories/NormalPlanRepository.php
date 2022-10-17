<?php

namespace App\Repositories;

use App\Models\NormalPlan;

class NormalPlanRepository
{
    public function find(int $planId): ?NormalPlan
    {
        return NormalPlan::find($planId);
    }
}

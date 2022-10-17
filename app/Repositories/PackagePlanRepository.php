<?php

namespace App\Repositories;

use App\Models\PackagePlan;

class PackagePlanRepository
{
    public function find(int $planId): ?PackagePlan
    {
        return PackagePlan::find($planId);
    }
}

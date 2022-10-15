<?php

namespace App\Models;

use App\Models\Plan\PlanContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $price
 * @property int $base_plan_id
 * @property array $extra_bonus
 * @property string $description
 * @property NormalPlan $basePlan
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PackagePlan extends Model implements PlanContract
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'extra_bonus' => 'array',
    ];

    /**
     * Get the basePlan associated with the PackagePlan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function basePlan(): HasOne
    {
        return $this->hasOne(NormalPlan::class, 'id', 'base_plan_id');
    }
}

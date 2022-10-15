<?php

namespace App\Models;

use App\Models\Order\PlanType;
use App\Models\Order\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $plan_id
 * @property PlanType $plan_type
 * @property Status $status
 * @property PackagePlan|NormalPlan $plan
 * @property Collection<ReservedJob> $reservedJobs
 * @property Carbon $started_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
        'plan_type' => PlanType::class,
    ];

    /**
     * Get the plan associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plan(): HasOne
    {
        return match ($this->plan_type) {
            PlanType::NORMAL => $this->hasOne(NormalPlan::class, 'id', 'plan_id'),
            PlanType::PACKAGE => $this->hasOne(PackagePlan::class),
        };
    }

    /**
     * Get all of the reservedJobs for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservedJobs(): HasMany
    {
        return $this->hasMany(ReservedJob::class, 'order_id');
    }
}

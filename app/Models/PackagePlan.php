<?php

namespace App\Models;

use App\Models\Order\PlanType;
use App\Models\Plan\PlanContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function basePlan(): BelongsTo
    {
        return $this->belongsTo(NormalPlan::class, 'id', 'base_plan_id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getTerm(): int
    {
        return $this->basePlan->term;
    }

    public function getPlanType(): PlanType
    {
        return PlanType::PACKAGE;
    }
}

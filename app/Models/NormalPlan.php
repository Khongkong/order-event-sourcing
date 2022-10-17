<?php

namespace App\Models;

use App\Models\Order\PlanType;
use App\Models\Plan\PlanContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $description
 * @property int $term
 * @property int $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class NormalPlan extends Model implements PlanContract
{
    use HasFactory;

    protected $guarded = [];

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
        return $this->term;
    }

    public function getPlanType(): PlanType
    {
        return PlanType::NORMAL;
    }
}

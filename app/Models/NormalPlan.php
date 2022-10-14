<?php

namespace App\Models;

use App\Models\Plan\PlanContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormalPlan extends Model implements PlanContract
{
    use HasFactory;

    protected $guarded = [];
}

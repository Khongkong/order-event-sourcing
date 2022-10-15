<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property $id
 * @property $job_id
 * @property $order_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReservedJob extends Model
{
    use HasFactory;

    protected $guarded = [];
}

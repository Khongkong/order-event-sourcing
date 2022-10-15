<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Job extends Model
{
    use HasFactory;

    protected $guarded = [];
}

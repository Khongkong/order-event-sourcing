<?php

namespace App\Repositories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;

class JobRepository
{

    public function getJobs(array $jobIds): Collection
    {
        return Job::query()
            ->whereIn('id', $jobIds)
            ->get();
    }
}

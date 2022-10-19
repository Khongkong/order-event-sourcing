<?php

namespace App\Repositories;

use App\Models\ReservedJob;

class ReservedJobRepository
{

    public function addReservingJobs(int $orderId, array $jobIds): void
    {
        $insertData = collect($jobIds)
            ->map(fn (int $jobId): array => [
                'order_id' => $orderId,
                'job_id' => $jobId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        ReservedJob::query()
            ->insert($insertData->toArray());
    }
}

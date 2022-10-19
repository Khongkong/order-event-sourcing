<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class JobsReserved extends ShouldBeStored
{
    public function __construct(
        private readonly int $orderId,
        private readonly array $jobIds,
        private readonly int $companyId
    ) {}

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getJobIds(): array
    {
        return $this->jobIds;
    }
}

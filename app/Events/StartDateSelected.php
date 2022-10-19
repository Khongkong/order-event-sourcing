<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class StartDateSelected extends ShouldBeStored
{
    public function __construct(
        private readonly int $startedAtTimestamp,
        private readonly int $companyId
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getStartedAtTimestamp(): int
    {
        return $this->startedAtTimestamp;
    }
}

<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class StartDateSelected extends ShouldBeStored
{
    public function __construct(
        private int $startedAtTimestamp,
        private int $companyId
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

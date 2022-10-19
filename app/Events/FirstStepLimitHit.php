<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class FirstStepLimitHit extends ShouldBeStored
{
    public function __construct(
        private readonly int $companyId,
    ){}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }
}

<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderInitiated extends ShouldBeStored
{
    public function __construct(
        private int $companyId
    ) {
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }
}

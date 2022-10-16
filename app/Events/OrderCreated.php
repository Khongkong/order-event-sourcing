<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderCreated extends ShouldBeStored
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

<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderConfirmed extends ShouldBeStored
{
    public function __construct(
        private readonly int $companyId,
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }
}

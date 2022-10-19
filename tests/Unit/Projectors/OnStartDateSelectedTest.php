<?php

namespace Tests\Unit\Projectors;

use App\Events\StartDateSelected;
use Mockery;
use Mockery\MockInterface;

class OnStartDateSelectedTest extends OrderProjectorTest
{
    private const COMPANY_ID = 29232;

    /**
     * @test
     */
    public function startDateSelected(): void
    {
        $this->orderRepository->expects('updateStartDate');
        $this->target()->onStartDateSelected($this->mockStartDateSelectedEvent());
    }

    private function mockStartDateSelectedEvent(): MockInterface&StartDateSelected
    {
        $event = Mockery::mock(StartDateSelected::class);
        $event->allows([
            'getCompanyId' => self::COMPANY_ID,
            'getStartedAtTimestamp' => now()->getTimestamp(),
        ]);
        return $event;
    }
}

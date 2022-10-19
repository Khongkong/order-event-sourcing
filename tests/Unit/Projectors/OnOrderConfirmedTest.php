<?php

namespace Tests\Unit\Projectors;

use App\Events\OrderConfirmed;
use Mockery;
use Mockery\MockInterface;

class OnOrderConfirmedTest extends OrderProjectorTest
{
    private const COMPANY_ID = 435983;

    /**
     * @test
     */
    public function orderConfirmedSuccessfully(): void
    {
        $this->orderRepository->expects('confirmOrder')
            ->with(self::COMPANY_ID);
        $this->target()->onOrderConfirmed($this->mockOrderConfirmedEvent());
    }

    private function mockOrderConfirmedEvent(): MockInterface&OrderConfirmed
    {
        $event = Mockery::mock(OrderConfirmed::class);
        $event->allows([
            'getCompanyId' => self::COMPANY_ID,
        ]);
        return $event;
    }
}

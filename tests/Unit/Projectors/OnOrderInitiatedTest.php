<?php

namespace Tests\Unit\Projectors;

use App\Events\OrderInitiated;
use App\Models\Order;
use Mockery;
use Mockery\MockInterface;

class OnOrderInitiatedTest extends OrderProjectorTest
{
    private const COMPANY_ID = 432894;

    private const UUID = '93288831-9c26-4ea5-ba48-ab8d09b09542';

    /**
     * @test
     */
    public function orderInitiatedWhenNoOrderIsFound(): void
    {
        $this->orderRepository
            ->expects('findCurrentOrder')
            ->with(self::COMPANY_ID)
            ->andReturnNull();
        $this->orderRepository
            ->expects('createNewOrder')
            ->with(self::COMPANY_ID, self::UUID);
        $this->target()->onOrderInitiated($this->mockOrderInitiatedEvent());
    }

    /**
     * @test
     */
    public function orderInitiatedWhenOrderIsFound(): void
    {
        $this->orderRepository
            ->expects('findCurrentOrder')
            ->with(self::COMPANY_ID)
            ->andReturns(Order::factory()->makeOne(['company_id' => self::COMPANY_ID]));
        $this->orderRepository
            ->allows('createNewOrder')
            ->never();
        $this->target()->onOrderInitiated($this->mockOrderInitiatedEvent());
    }

    private function mockOrderInitiatedEvent(): MockInterface&OrderInitiated
    {
        $event = Mockery::mock(OrderInitiated::class)->makePartial();
        $event->allows([
            'aggregateRootUuid' => self::UUID,
            'getCompanyId' => self::COMPANY_ID,
        ]);
        return $event;
    }
}

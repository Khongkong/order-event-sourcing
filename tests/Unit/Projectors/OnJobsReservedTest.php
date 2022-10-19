<?php

namespace Tests\Unit\Projectors;

use App\Events\JobsReserved;
use App\Models\Job;
use App\Projectors\Exceptions\UnidentifiedJobException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Mockery;
use Mockery\MockInterface;

class OnJobsReservedTest extends OrderProjectorTest
{
    private const COMPANY_ID = 34982;
    private const ORDER_ID = 849333;
    private const JOB_IDS = [
        956402,
        342903,
        203224,
    ];

    /**
     * @test
     */
    public function jobReservedSuccessfully(): void
    {
        $this->jobRepository->expects('getJobs')
            ->with(self::JOB_IDS)
            ->andReturns(Job::factory(count(self::JOB_IDS))->make([
                'company_id' => self::COMPANY_ID,
            ]));
        $this->reservedJobRepository->expects('addReservingJobs')
            ->with(self::ORDER_ID, self::JOB_IDS);
        $this->orderRepository->expects('updateOrderReservingJobs')
            ->with(self::COMPANY_ID);
        $this->target()->onJobsReserved($this->mockJobReservedEvent(self::JOB_IDS));
    }

    /**
     * @test
     */
    public function jobReservedSuccessfullyWithNoJobsShouldBeReserved(): void
    {
        $this->jobRepository->expects('getJobs')
            ->with([])
            ->andReturns(new EloquentCollection());
        $this->reservedJobRepository->allows('addReservingJobs')
            ->never();
        $this->orderRepository->expects('updateOrderReservingJobs')
            ->with(self::COMPANY_ID);
        $this->target()->onJobsReserved($this->mockJobReservedEvent([]));
    }

    /**
     * @test
     */
    public function someJobsAreUnidentified(): void
    {
        $this->expectException(UnidentifiedJobException::class);
        $this->jobRepository->expects('getJobs')
            ->with(self::JOB_IDS)
            ->andReturns(new EloquentCollection());
        $this->target()->onJobsReserved($this->mockJobReservedEvent(self::JOB_IDS));
    }

    private function mockJobReservedEvent(array $jobIds): MockInterface&JobsReserved
    {
        $event = Mockery::mock(JobsReserved::class);
        $event->allows([
            'getCompanyId' => self::COMPANY_ID,
            'getOrderId' => self::ORDER_ID,
            'getJobIds' => $jobIds,
        ]);

        return $event;
    }
}

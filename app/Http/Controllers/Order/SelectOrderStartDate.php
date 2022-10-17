<?php

namespace App\Http\Controllers\Order;

use App\Aggregates\OrderAggregateRoot;
use App\Exceptions\Order\OrderMissingException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SelectOrderStartDate extends Controller
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function __invoke(
        Request $request
    ): Response
    {
        /**
         * @var User $user
         */
        $user = auth()->user();
        $orderUuid = $this->getUuid($user);
        OrderAggregateRoot::retrieve($orderUuid)
            ->selectStartDate($request->integer('startedAt'), $user->company_id)
            ->persist();

        return response(['result' => 'success']);
    }

    private function getUuid(User $user): string
    {
        $order = $this->orderRepository->findCurrentOrder($user->company_id);
        if ($order === null) {
            throw new OrderMissingException();
        }
        return $order->uuid;
    }
}

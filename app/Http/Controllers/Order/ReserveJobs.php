<?php

namespace App\Http\Controllers\Order;

use App\Aggregates\OrderAggregateRoot;
use App\Exceptions\Order\InvalidJobException;
use App\Exceptions\Order\OrderMissingException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Projectors\Exceptions\UnidentifiedJobException;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReserveJobs extends Controller
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function __invoke(
        Request $request
    ): Response {
        /**
         * @var User $user
         */
        $user = auth()->user();
        $order = $this->getCurrentOrder($user);
        try {
            OrderAggregateRoot::retrieve($order->uuid)
                ->reserveJobs($order->id, $request->input('jobIds'), $user->company_id)
                ->persist();
        } catch (UnidentifiedJobException $e) {
            throw new InvalidJobException();
        }
        return response([
            'result' => 'success',
        ]);
    }

    private function getCurrentOrder(User $user): Order
    {
        $order = $this->orderRepository->findCurrentOrder($user->company_id);
        if ($order === null) {
            throw new OrderMissingException();
        }
        return $order;
    }
}

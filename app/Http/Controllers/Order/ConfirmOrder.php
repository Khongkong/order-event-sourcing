<?php

namespace App\Http\Controllers\Order;

use App\Aggregates\OrderAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ConfirmOrder extends Controller
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function __invoke(
        Request $request
    ): Response {
        /**
         * @var User|null $user
         */
        $user = auth()->user();
        if ($user === null) {
            return response([
                'result' => 'user not logged in or not found',
            ], SymfonyResponse::HTTP_FORBIDDEN);
        }

        try {
            $orderUuid = $this->getUuid($user);
        } catch (\UnexpectedValueException $e) {
            return response([
                'errors' => 'order should be created first',
            ], SymfonyResponse::HTTP_FORBIDDEN);
        }

        OrderAggregateRoot::retrieve($orderUuid)
            ->confirmOrder($user->company_id)
            ->persist();
        return response([
            'result' => 'success',
        ]);
    }

    private function getUuid(User $user): string
    {
        $order = $this->orderRepository->findCurrentOrder($user->company_id);
        if ($order === null) {
            throw new \UnexpectedValueException('Order not found');
        }
        return $order->uuid;
    }
}

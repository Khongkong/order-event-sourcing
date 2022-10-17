<?php

namespace App\Http\Controllers\Order;

use App\Aggregates\OrderAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\Order\PlanType;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SelectOrderPlan extends Controller
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function __invoke(Request $request): Response
    {
        /**
         * @var User|null $user
         */
        $user = auth()->user();
        if ($user === null) {
            return response([
                'result' => 'user not logged in or not found',
            ], SymfonyResponse::HTTP_FORBIDDEN);
        }

        OrderAggregateRoot::retrieve($this->getUuid($user))
            ->createOrder($user->company_id)
            ->selectPlan($request->integer('planType'), $request->integer('planId'), $user->company_id)
            ->persist();

        return response([
            'result' => 'success',
        ]);
    }

    private function getUuid(User $user): string
    {
        $order = $this->orderRepository->findCurrentOrder($user->company_id);
        return $order?->uuid ?? (string) Str::uuid();
    }
}

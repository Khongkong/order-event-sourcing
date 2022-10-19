<?php

namespace App\Http\Controllers\Order;

use App\Aggregates\OrderAggregateRoot;
use App\Exceptions\InvalidPlanException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Projectors\Exceptions\PlanNotFoundException;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SelectOrderPlan extends Controller
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function __invoke(Request $request): Response
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        try {
            OrderAggregateRoot::retrieve($this->getUuid($user))
                ->initiateOrder($user->company_id)
                ->selectPlan($request->integer('planType'), $request->integer('planId'), $user->company_id)
                ->persist();
        } catch (PlanNotFoundException $e) {
            throw new InvalidPlanException();
        }

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

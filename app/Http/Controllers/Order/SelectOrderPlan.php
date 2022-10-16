<?php

namespace App\Http\Controllers\Order;

use App\Aggregates\OrderAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SelectOrderPlan extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        dd($user->company);
        $uuid = (string) Str::uuid();
        OrderAggregateRoot::retrieve($uuid)
            ->createOrder($user->company_id)
            ->persist();

        return response([
            'result' => 'success',
        ]);
    }
}

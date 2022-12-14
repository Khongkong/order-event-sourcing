<?php

use App\Http\Controllers\Auth\GetCurrentUserAction;
use App\Http\Controllers\Auth\LoginAction;
use App\Http\Controllers\Auth\LogoutAction;
use App\Http\Controllers\Order\ConfirmOrder;
use App\Http\Controllers\Order\ReserveJobs;
use App\Http\Controllers\Order\SelectOrderPlan;
use App\Http\Controllers\Order\SelectOrderStartDate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', LoginAction::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', LogoutAction::class);
    Route::get('user', GetCurrentUserAction::class);
    Route::prefix('orders')->group(function () {
        Route::put('plan', SelectOrderPlan::class);
        Route::put('date', SelectOrderStartDate::class);
        Route::put('reserve-jobs', ReserveJobs::class);
        Route::put('confirm', ConfirmOrder::class);
    });
});

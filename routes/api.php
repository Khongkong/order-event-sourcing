<?php

use App\Http\Controllers\Auth\GetCurrentUserAction;
use App\Http\Controllers\Auth\LoginAction;
use App\Http\Controllers\Auth\LogoutAction;
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
});

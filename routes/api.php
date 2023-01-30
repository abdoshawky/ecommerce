<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\OrderController;
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

Route::get('items', [ItemController::class, 'index']);

Route::apiResource('carts', CartController::class);

Route::post('orders', [OrderController::class, 'store']);

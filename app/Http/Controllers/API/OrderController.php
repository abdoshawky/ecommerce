<?php

namespace App\Http\Controllers\API;

use App\Classes\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(CreateOrderRequest $request)
    {
        $this->orderService->createFromCart(Auth::user(), $request->address, $request->telephone);
        return response()->json(['message' => 'order created']);
    }
}

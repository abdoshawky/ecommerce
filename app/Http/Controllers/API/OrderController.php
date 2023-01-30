<?php

namespace App\Http\Controllers\API;

use App\Classes\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $request)
    {
        $customer = Auth::user();
        $carts = $customer->carts;
        $cartTotal = $carts->sum('price');

        // Validate cart is not empty
        if ($carts->count() == 0) {
            abort(400, 'Cart is empty');
        }

        // Validate user credits against order price
        if ($customer->store_credits < $cartTotal) {
            abort(400, 'Not enough credit');
        }

        DB::beginTransaction();
        try {
            $order = $customer->orders()->create($request->validated() + ['total' => $cartTotal]);
            foreach ($carts as $cart) {
                $order->items()->attach($cart->item_id, ['price' => $cart->item->price, 'quantity' => $cart->quantity]);

                $cart->delete();
            }

            $customer->store_credits -= $cartTotal;
            $customer->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            abort(400, $exception->getMessage());
        }

        return response()->json(['message' => 'order created']);
    }
}

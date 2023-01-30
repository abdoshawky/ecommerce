<?php

namespace App\Http\Controllers\API;

use App\Classes\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddItemToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $customer = Auth::user()->load('carts.item');
        $carts = $customer->carts;

        return response()->json(
            [
                'carts' => CartResource::collection($carts),
                'total' => $carts->sum('price')
            ]
        );
    }

    public function store(AddItemToCartRequest $request): JsonResponse
    {
        $cart = Auth::user()->carts()->where('item_id', $request->item_id)->first();
        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            $cart = Auth::user()->carts()->create($request->validated());
        }

        return response()->json(['cart' => CartResource::make($cart)]);
    }

    public function update(UpdateCartRequest $request, Cart $cart): JsonResponse
    {
        $cart->update($request->validated());

        return response()->json(['cart' => CartResource::make($cart)]);
    }

    public function destroy(Cart $cart): JsonResponse
    {
        $cart->delete();

        return response()->json([], 204);
    }
}

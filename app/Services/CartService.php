<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Item;

class CartService
{
    public function addItemToCart(Item $item, Customer $customer, int $quantity = 1): Cart
    {
        $cart = $customer->carts()->where('item_id', $item->id)->first();
        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            $cart = $customer->carts()->create(['item_id' => $item->id, 'quantity' => $quantity]);
        }

        return $cart;
    }

}

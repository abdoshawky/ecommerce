<?php

namespace App\Services;

use App\Exceptions\EmptyCartException;
use App\Exceptions\NotEnoughCreditException;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Exception;
use Throwable;

class OrderService
{

    /**
     * @throws EmptyCartException
     * @throws NotEnoughCreditException
     */
    public function createFromCart(Customer $customer, $address, $telephone): Order
    {
        $carts = $customer->carts;
        $cartTotal = $carts->sum('price');

        $this->validateCustomerCart($customer);
        $this->validateCustomerCredit($customer);

        DB::beginTransaction();
        try {
            $order = $customer->orders()->create(
                ['total' => $cartTotal, 'address' => $address, 'telephone' => $telephone]
            );
            foreach ($carts as $cart) {
                $order->items()->attach($cart->item_id, ['price' => $cart->item->price, 'quantity' => $cart->quantity]);

                $cart->delete();
            }

            $customer->removeStoreCredits($cartTotal);

            DB::commit();

            return $order;
        } catch (Throwable $exception) {
            DB::rollBack();
            abort(400, $exception->getMessage());
        }
    }

    /**
     * @throws EmptyCartException
     */
    private function validateCustomerCart(Customer $customer): void
    {
        // Validate cart is not empty
        if ($customer->carts()->count() == 0) {
            throw new EmptyCartException();
        }
    }

    /**
     * @throws NotEnoughCreditException
     */
    private function validateCustomerCredit(Customer $customer): void
    {
        // Validate user credits against order price
        if ($customer->store_credits < $customer->carts->sum('price')) {
            throw new NotEnoughCreditException();
        }
    }

}

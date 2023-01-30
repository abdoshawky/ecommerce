<?php

namespace Tests\Feature;

use App\Classes\Auth;
use App\Models\Cart;
use App\Models\Item;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_an_order()
    {
        $customer = Auth::user();
        $customer->addStoreCredits(40);
        $item = Item::factory()->create(['price' => 40]);
        Cart::factory()->create(['item_id' => $item->id, 'customer_id' => $customer->id]);

        $response = $this->post('/api/orders', ['address' => "test address", "telephone" => "0123456789"]);

        $response
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_throw_exception_if_not_enough_credit()
    {
        $customer = Auth::user();
        $item = Item::factory()->create(['price' => 200]);
        Cart::factory()->create(['item_id' => $item->id, 'customer_id' => $customer->id]);

        $response = $this->post('/api/orders', ['address' => "test address", "telephone" => "0123456789"]);

        $response
            ->assertStatus(400);
    }
}

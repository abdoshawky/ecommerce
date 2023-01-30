<?php

namespace Tests\Feature;

use App\Classes\Auth;
use App\Models\Cart;
use App\Models\Item;
use Tests\TestCase;

class CartTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_carts()
    {
        Cart::factory()->create(['customer_id' => Auth::user()->id]);

        $response = $this->get('/api/carts');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'carts' => [
                        ['id', 'item' => ['id', 'name', 'description', 'price'], 'price']
                    ],
                    'total'
                ]
            );
    }

    /**
     * @test
     */
    public function it_can_add_item_to_cart()
    {
        $item = Item::factory()->create(['price' => 10]);
        $response = $this->post('/api/carts', ['item_id' => $item->id, 'quantity' => 4]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'cart' => [
                        'id',
                        'item' => ['id', 'name', 'description', 'price'],
                        'price'
                    ]
                ]
            )
            ->assertJson(
                [
                    'cart' => ['item' => ['id' => $item->id], 'price' => 40]
                ]
            );
    }

    /**
     * @test
     */
    public function it_can_update_cart()
    {
        $item = Item::factory()->create(['price' => 10]);
        $cart = Cart::factory()->create(['item_id' => $item->id, 'customer_id' => Auth::user()->id]);

        $response = $this->put('/api/carts/' . $cart->id, ['quantity' => 5]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'cart' => [
                        'id',
                        'item' => ['id', 'name', 'description', 'price'],
                        'price'
                    ]
                ]
            )
            ->assertJson(
                [
                    'cart' => ['item' => ['id' => $item->id], 'price' => 50]
                ]
            );
    }

    /**
     * @test
     */
    public function it_can_delete_cart()
    {
        $cart = Cart::factory()->create(['customer_id' => Auth::user()->id]);

        $response = $this->delete('/api/carts/' . $cart->id);

        $response->assertStatus(204);
    }
}

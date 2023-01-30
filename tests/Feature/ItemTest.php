<?php

namespace Tests\Feature;

use Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_items()
    {
        $response = $this->get('/api/items');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'items' => [
                        ['id', 'name', 'description', 'price']
                    ]
                ]
            );
    }
}

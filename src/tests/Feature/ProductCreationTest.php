<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_create_a_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/items/create', [
            'title' => 'テスト商品',
            'description' => 'これはテスト商品です。',
            'price' => 1000,
        ]);

        $response->assertRedirect('/items');
        $this->assertDatabaseHas('items', [
            'title' => 'テスト商品',
            'description' => 'これはテスト商品です。',
            'price' => 1000,
        ]);
    }
}

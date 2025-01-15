<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class PaymentMethodSelectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_selected_payment_method_is_reflected_in_checkout_screen()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'クレジットカード',
        ]);

        $response->assertRedirect('/purchase/' . $item->id);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'クレジットカード',
        ]);
    }
}

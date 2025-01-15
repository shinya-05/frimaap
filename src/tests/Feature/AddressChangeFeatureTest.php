<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;

class AddressChangeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_shipping_address_is_updated_and_reflected_on_checkout_screen()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->post('/purchase/' . $item->id . '/update-address', [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building_name' => '渋谷ビル',
        ]);

        $response->assertRedirect('/purchase/' . $item->id);
        $this->assertDatabaseHas('orders', [
            'postal_code' => '123-4567',
            'shipping_address' => '東京都渋谷区',
            'building_name' => '渋谷ビル',
        ]);
    }

    /** @test */
    public function test_shipping_address_is_recorded_in_order_when_purchased()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'クレジットカード',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building_name' => '渋谷ビル',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '123-4567',
            'shipping_address' => '東京都渋谷区',
            'building_name' => '渋谷ビル',
        ]);
    }
}

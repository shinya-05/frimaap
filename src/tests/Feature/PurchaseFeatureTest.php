<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;

class PurchaseFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** 購入ボタンを押下すると購入が完了する */
    public function test_purchase_is_completed()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['status' => 'sale']);

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'クレジットカード',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'クレジットカード',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => 'sold',
        ]);
    }

    /** 購入した商品が購入履歴に追加される */
    public function test_purchased_item_appears_in_purchase_history()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['status' => 'sold']);

        Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'クレジットカード',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage?tab=purchased');

        $response->assertSee($item->title);
    }
}

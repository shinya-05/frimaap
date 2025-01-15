<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    /** 全商品を取得できる */
    public function test_all_items_are_displayed()
    {
        Item::factory(5)->create();

        $response = $this->get('/');

        $response->assertStatus(200)
                 ->assertSee(Item::first()->title);
    }

    /** 購入済み商品はSoldと表示される */
    public function test_sold_items_are_marked()
    {
        $item = Item::factory()->create(['status' => 'sold']);

        $response = $this->get('/');

        $response->assertStatus(200)
                 ->assertSee('Sold');
    }

    /** 自分が出品した商品は表示されない */
    public function test_user_items_are_not_displayed()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200)
                 ->assertDontSee($item->title);
    }
}

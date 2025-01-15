<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /** いいねした商品だけが表示される */
    public function test_only_favorited_items_are_displayed()
    {
        $user = User::factory()->create();
        $favoritedItem = Item::factory()->create();
        $otherItem = Item::factory()->create();

        $favoritedItem->favoritedBy()->attach($user);

        $this->actingAs($user);

        $response = $this->get('/mylist');

        $response->assertStatus(200)
                 ->assertSee($favoritedItem->title)
                 ->assertDontSee($otherItem->title);
    }

    /** 購入済み商品はSoldと表示される */
    public function test_sold_items_are_marked_in_mylist()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['status' => 'sold']);
        $item->favoritedBy()->attach($user);

        $this->actingAs($user);

        $response = $this->get('/mylist');

        $response->assertStatus(200)
                 ->assertSee('Sold');
    }

    /** 自分が出品した商品は表示されない */
    public function test_user_items_are_not_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $user->id]);

        $item->favoritedBy()->attach($user);

        $this->actingAs($user);

        $response = $this->get('/mylist');

        $response->assertStatus(200)
                 ->assertDontSee($item->title);
    }
}

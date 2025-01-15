<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class LikeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** いいねアイコンを押すといいね商品として登録される */
    public function test_can_like_a_product()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/items/' . $item->id . '/favorite');

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** 再度いいねアイコンを押すといいねが解除される */
    public function test_can_unlike_a_product()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/items/' . $item->id . '/favorite');
        $this->actingAs($user)->post('/items/' . $item->id . '/favorite');

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}

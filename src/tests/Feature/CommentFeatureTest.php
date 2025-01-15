<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class CommentFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** ログイン済みのユーザーはコメントを送信できる */
    public function test_authenticated_user_can_send_comments()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/comments', [
            'content' => '素晴らしい商品です！',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => '素晴らしい商品です！',
        ]);
    }

    /** コメントが入力されていない場合、バリデーションエラーが発生する */
    public function test_cannot_send_empty_comments()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/comments', [
            'content' => '',
        ]);

        $response->assertSessionHasErrors([
            'content' => 'コメントを入力してください',
        ]);
    }
}

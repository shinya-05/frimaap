<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** ログアウトができる */
    public function test_user_can_logout()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user); // ユーザーを認証状態に設定

        $response = $this->post('/logout');

        $response->assertRedirect('/'); // ログアウト後のリダイレクト先
        $this->assertGuest(); // ユーザーがログアウトしていることを確認
    }
}

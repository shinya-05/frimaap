<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** メールアドレスが入力されていない場合、バリデーションメッセージが表示される */
    public function test_email_is_required()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    /** パスワードが入力されていない場合、バリデーションメッセージが表示される */
    public function test_password_is_required()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    /** 入力情報が間違っている場合、バリデーションメッセージが表示される */
    public function test_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }

    /** 正しい情報が入力されている場合、ログインが成功する */
    public function test_successful_login()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/'); // ログイン成功後のリダイレクト
        $this->assertAuthenticatedAs($user);
    }
}

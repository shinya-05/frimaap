<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserInfoRetrievalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_info_is_displayed_on_profile_page()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200)
                 ->assertSee('テストユーザー')
                 ->assertSee('123-4567')
                 ->assertSee('東京都渋谷区');
    }
}

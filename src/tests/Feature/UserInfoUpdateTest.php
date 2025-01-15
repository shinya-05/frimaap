<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserInfoUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_update_profile_info()
    {
        $user = User::factory()->create([
            'name' => '旧ユーザー名',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $response = $this->actingAs($user)->post('/profile/update', [
            'name' => '新ユーザー名',
            'postal_code' => '987-6543',
            'address' => '東京都港区',
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('users', [
            'name' => '新ユーザー名',
            'postal_code' => '987-6543',
            'address' => '東京都港区',
        ]);
    }
}

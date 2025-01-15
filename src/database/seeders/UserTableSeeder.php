<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => '山田 太郎',
                'email' => 'taro@example.com',
                'password' => Hash::make('password123'), // パスワードをハッシュ化
                'postal_code' => '123-4567',
                'address' => '東京都新宿区西新宿',
                'building_name' => '新宿ビル101',
                'profile_image' => null,
                'profile_completed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '佐藤 花子',
                'email' => 'hanako@example.com',
                'password' => Hash::make('password123'), // パスワードをハッシュ化
                'postal_code' => '765-4321',
                'address' => '大阪府大阪市中央区',
                'building_name' => '大阪タワー202',
                'profile_image' => null,
                'profile_completed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '田中 一郎',
                'email' => 'ichiro@example.com',
                'password' => Hash::make('password123'), // パスワードをハッシュ化
                'postal_code' => '987-6543',
                'address' => '北海道札幌市北区',
                'building_name' => '札幌マンション303',
                'profile_image' => null,
                'profile_completed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

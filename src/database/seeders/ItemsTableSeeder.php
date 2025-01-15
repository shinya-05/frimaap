<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'title' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'condition_id' => 2, // 良好
                'user_id' => 1, // 適切なユーザーIDを設定
                'status' => 'sale',
                'brand' => 'Armani',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'condition_id' => 1, // 目立った傷や汚れなし
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'SONY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'condition_id' => 3, // やや傷や汚れあり
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'なし',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'condition_id' => 4, // 状態が悪い
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'REGAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'condition_id' => 2, // 良好
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'Mac',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'condition_id' => 1, // 目立った傷や汚れなし
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'ホシデン',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'condition_id' => 3, // やや傷や汚れあり
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'ルイ・ヴィトン',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'condition_id' => 4, // 状態が悪い
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'バカラ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'コーヒーミルク',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'condition_id' => 2, // 良好
                'user_id' => 1,
                'status' => 'sale',
                'brand' => '雪印',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'condition_id' => 1, // 目立った傷や汚れなし
                'user_id' => 1,
                'status' => 'sale',
                'brand' => 'CHANEL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

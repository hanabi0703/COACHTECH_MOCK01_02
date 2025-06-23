<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');
        $param = [
            ['name' => '腕時計',
            'price' => '15000',
            'image' => 'Armani+Mens+Clock.jpg',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => 'HDD',
            'price' => '5000',
            'image' => 'HDD+Hard+Disk.jpg',
            'description' => '高速で信頼性の高いハードディスク',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => '玉ねぎ3束',
            'price' => '300',
            'image' => 'iLoveIMG+d.jpg',
            'description' => '新鮮な玉ねぎ3束のセット',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => '革靴',
            'price' => '4000',
            'image' => 'Leather+Shoes+Product+Photo.jpg',
            'description' => 'クラシックなデザインの革靴',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => 'ノートPC',
            'price' => '45000',
            'image' => 'Living+Room+Laptop.jpg',
            'description' => '高性能なノートパソコン',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => 'マイク',
            'price' => '8000',
            'image' => 'Music+Mic+4632231.jpg',
            'description' => '高音質のレコーディング用マイク',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => 'ショルダーバッグ',
            'price' => '3500',
            'image' => 'Purse+fashion+pocket.jpg',
            'description' => 'おしゃれなショルダーバッグ',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => 'タンブラー',
            'price' => '500',
            'image' => 'Tumbler+souvenir.jpg',
            'description' => '使いやすいタンブラー',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => 'コーヒーミル',
            'price' => '4000',
            'image' => 'Waitress+with+Coffee+Grinder.jpg',
            'description' => '手動のコーヒーミル',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1'],
            ['name' => 'メイクセット',
            'price' => '2500',
            'image' => '外出メイクアップセット.jpg',
            'description' => '便利なメイクアップセット',
            'user_id' => '1',
            'is_sold_out' => '0',
            'condition_id' => '1']
        ];
        DB::table('products')->insert($param);
    }
}

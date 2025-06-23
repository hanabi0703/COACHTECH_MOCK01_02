<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;


class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;

    public function test_example()
    {

        // シードの実行
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(UsersTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);


        // 出品商品情報登録
        // 1.商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、商品の説明、販売価格）
        Profile::factory()->create([
            'user_id' => '1',
            'name' => 'test name',
            'image' => 'Armani+Mens+Clock.jpg',
            'post_code' => '111-2222',
            'address' => 'test address',
            'building' => 'test building',
        ]);
        Product::factory()->create([
            'name' => 'テスト出品2',
            'price' => '500',
            'image' => 'Armani+Mens+Clock.jpg',
            'description' => 'test',
            'condition_id' => '1',
            'user_id' => '1',
            'is_sold_out' => '0',
        ]);
        $response = $this->get('/login');
        $response->assertStatus(200);

        $user = User::where('email', 'test@test.com')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->get('/sell');
        $response->assertStatus(200);

        $postResponse = $this->post('/sell', [
            'name' => 'テスト出品1',
            'price' => '1000',
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
            'user_id' => '1',
            'description' => 'testtesttest',
            'condition_id' => '1',
            'category_ids' => [1,2],
        ]);
        $product = Product::where('name','=', 'テスト出品1')->first();
        $postResponse->assertStatus(302);
        $this->assertDatabaseHas('products', [
            'name' => 'テスト出品1',
            'price' => '1000',
            'user_id' => '1',
            'description' => 'testtesttest',
            'condition_id' => '1',
        ]);
        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => '1',
        ]);
        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => '2',
        ]);

        // ユーザー情報取得
        // 1.必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）

        $response = $this->get('/mypage');
        $response->assertStatus(200);

        $buyProduct = Product::where('name','=', 'テスト出品2')->first();
        $postResponse = $this->post('/buy', [
            'id' => $buyProduct->id,
            'user_id' => '1',
            'payment' => '1',
            'post_code' => '123-4567',
            'address' => 'testAddress',
            'building' => 'testBill',
        ]);
        $response->assertSee('テスト出品1');
        $response->assertSee('テスト出品2');

        // ユーザー情報変更
        // 1.変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertSee('test name');
        $response->assertSee('111-2222');
        $response->assertSee('test address');
        $response->assertSee('test building');
    }
}
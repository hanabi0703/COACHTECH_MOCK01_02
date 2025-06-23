<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Purchase;


class PurchaseTest extends TestCase
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

        // 商品購入機能
        // 1.「購入する」ボタンを押下すると購入が完了する
        // 2.購入した商品は商品一覧画面にて「sold」と表示される

        Product::factory()->create([
            'name' => 'テスト出品',
            'price' => '500',
            'image' => 'Armani+Mens+Clock.jpg',
            'description' => 'test',
            'condition_id' => '1',
            'user_id' => '1',
            'is_sold_out' => '0',
        ]);
        $user = User::factory()->create([
            'email' => 'test@testtest.com',
            'password' => Hash::make('password123'),
        ]);
        $profile = Profile::factory()->create([
            'user_id' => '2',
            'name' => 'テストユーザー',
            'image' => 'Armani+Mens+Clock.jpg',
            'post_code' => '111-2222',
            'address' => 'テスト',
            'building' => 'テスト',
        ]);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $user = User::where('email', 'test@testtest.com')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Sold');

        $response = $this->get('/item/1');
        $response->assertStatus(200);

        $response = $this->get('/purchase/1');
        $response->assertStatus(200);
        $response->assertViewIs('purchase');

        $postResponse = $this->post('/buy', [
            'id' => '11',
            'payment' => '1',
            'post_code' => $profile->post_code,
            'address' => $profile->address,
            'building' => $profile->building,
        ]);
        $product = Product::where('id','=', '11')->first();
        $this->assertEquals($product->is_sold_out, 1);
        $postResponse->assertViewIs('index');
        $postResponse->assertSee('Sold');

        // 3.「プロフィール/購入した商品一覧」に追加されている
        $response = $this->get('/mypage');
        $response->assertStatus(200);

        $this->assertEquals(1, substr_count($response->getContent(), 'テスト出品'));

        // 支払い方法選択機能
        // 1.小計画面で変更が即時反映される
        // 配送先変更機能
        // 1.送付先住所変更画面にて登録した住所が商品購入画面に反映されている
        $response = $this->get('/item/2');
        $response->assertStatus(200);
        $response = $this->get('/purchase/2');
        $response->assertStatus(200);
        $response = $this->get('/purchase/address/2');
        $response->assertStatus(200);

        $postResponse = $this->post('/purchase/2', [
            'id' => '2',
            'post_code' => '123-4567',
            'address' => 'testAddress',
            'building' => 'testBill',
        ]);
        $postResponse->assertSee('123-4567');
        $postResponse->assertSee('testAddress');
        $postResponse->assertSee('testBill');

        $postResponse = $this->post('/buy', [
            'id' => '2',
            'payment' => '2',
            'post_code' => '123-4567',
            'address' => 'testAddress',
            'building' => 'testBill',
        ]);

        $this->assertDatabaseHas('purchases', [
            'product_id' => 2,
            'payment' => '2',
            'post_code' => '123-4567',
            'address' => 'testAddress',
            'building' => 'testBill',
        ]);
    }
}

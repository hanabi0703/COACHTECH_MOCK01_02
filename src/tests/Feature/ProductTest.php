<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Condition;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductTest extends TestCase
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
        
        // 商品一覧取得
        // 1. 全商品を取得できる

        $products = Product::all();
        $users = User::all();
        $response = $this->get('/');
        $response->assertStatus(200);

        foreach ($products as $product) {
            $response->assertSee($product->name);
        }

        // 2. 購入済み商品は「Sold」と表示される
        Product::factory()->create([
            'name' => 'Soldout',
            'price' => '500',
            'image' => 'Armani+Mens+Clock.jpg',
            'description' => 'test',
            'condition_id' => '1',
            'user_id' => '1',
            'is_sold_out' => '1',
        ]);

        // $products = Product::all();
        $response = $this->get('/');
        $response->assertStatus(200);

        // dump($response);

        $response->assertSee('Sold',false);

        // 3.自分が出品した商品は表示されない
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

        $product = Product::factory()->create([
            'name' => 'bbb',
            'price' => '1000',
            'image' => 'Armani+Mens+Clock.jpg',
            'description' => 'test',
            'condition_id' => '1',
            'user_id' => '2',
            'is_sold_out' => '0',
        ]);
        $product->categories()->sync([1, 2, 3]);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'test@testtest.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);

        $response = $this->get('/');
        $response->assertStatus(200);

        $products = Product::where('user_id','=', '2')->get();

        foreach ($products as $product) {
            $response->assertDontSee($product->name);
            }
        $postResponse = $this->post('/logout');
        $response->assertStatus(200);

        // マイリスト一覧取得
        // 1. いいねした商品だけが表示される
        Like::factory()->create([
            'product_id' => '1',
            'user_id' => '2',
        ]);
        Like::factory()->create([
            'product_id' => '11',
            'user_id' => '2',
        ]);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'test@testtest.com',
            'password' => 'password123',
        ]);
        $response = $this->get('/');
        $response->assertStatus(200);

        $product = Product::where('id','=', '1')->first();
        $this->assertEquals(2, substr_count($response->getContent(), '<span>'.$product->name.'</span>'));

        // 2.購入済み商品は「Sold」と表示される

        $this->assertEquals(2, substr_count($response->getContent(), '<p class="product__sold">Sold</p>'));

        // 3.自分が出品した商品は表示されない

        $products = Product::where('user_id','=', '2')->get();

        foreach ($products as $product) {
            $response->assertDontSee($product->name);
            }

        // 4.未認証の場合は何も表示されない
        $postResponse = $this->post('/logout');
        $response->assertStatus(200);

        $response = $this->get('/');
        $response->assertStatus(200);

        $product = Product::where('id','=', '1')->first();
        $this->assertEquals(1, substr_count($response->getContent(), '<span>'.$product->name.'</span>'));

        // 商品検索機能
        // 1.検索状態がマイリストでも保持されている

        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/products/search');
        $response->assertStatus(200);


        // 商品詳細情報取得
        // 1.必要な情報が表示される（商品画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、商品情報（カテゴリ、商品の状態）、コメント数、コメントしたユーザー情報、コメント内容）

        Like::factory()->create([
            'product_id' => '12',
            'user_id' => '2',
        ]);
        Comment::factory()->create([
            'product_id' => '12',
            'user_id' => '2',
            'comment' => 'test comment'
        ]);
        $response = $this->get('/item/12');
        $response->assertStatus(200);

        $product = Product::where('id','=', '12')->first();
        $likeCount = Like::where('user_id','=', '2')->where('product_id','=', '12')->count();
        $commentCount = Comment::where('user_id','=', '2')->where('product_id','=', '12')->count();
        $comment = Comment::where('user_id','=', '2')->where('product_id','=', '12')->get();
        $condition = Condition::where('id','=', $product->condition_id)->first();
        $categories = $product->categories;

        $response->assertSee($product->image,false);
        $response->assertSee($product->name,false);
        $response->assertSee($product->price,false);
        $response->assertSee($product->description,false);
        $response->assertSee($condition->name,false);
        foreach ($categories as $category) {
            $response->assertSee($category->name,false);
        }
        // コメント件数
        $response = $this->get('/login');
        $response->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'test@testtest.com',
            'password' => 'password123',
        ]);

        $response = $this->get('/item/12');
        $response->assertStatus(200);

        $postResponse = $this->post('/product/12/comment', [
            'comment' => 'test comment',
        ])->assertRedirect();

        $this->assertEquals(1, substr_count($response->getContent(), '<div class="comment__comment">'));

        // コメント内容
        $response->assertSee('test comment',false);

        $response = $this->get('/item/12');

        // コメントのユーザー情報
        $profile = Profile::where('user_id','=', '2')->first();
        $response->assertSee($profile->name,false);

        $postResponse = $this->post('/logout');
        $response->assertStatus(200);

        // いいね機能
        // 1.いいねアイコンを押下することによって、いいねした商品として登録することができる。
        $response = $this->get('/login');
        $response->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'test@testtest.com',
            'password' => 'password123',
        ]);

        $response = $this->get('/item/2');
        $response->assertStatus(200);

        $postResponse = $this->post('/product/2/like');

        $this->assertDatabaseHas('likes', [
            'user_id' => 2,
            'product_id' => 2,
        ]);

        // 2.追加済みのアイコンは色が変化する
        $response->assertSee('star_black.svg');

        // 3.再度いいねアイコンを押下することによって、いいねを解除することができる。

        $postResponse = $this->post('/product/2/like');

        $this->assertDatabaseMissing('likes', [
            'user_id' => 2,
            'product_id' => 2,
        ]);

        $postResponse = $this->post('/logout');
        $response->assertStatus(200);


        // コメント送信機能
        // 1.ログイン済みのユーザーはコメントを送信できる
        // 3.コメントが入力されていない場合、バリデーションメッセージが表示される
        // 4.コメントが255字以上の場合、バリデーションメッセージが表示される
        $response = $this->get('/login');
        $response->assertStatus(200);

        $postResponse = $this->post('/login', [
            'email' => 'test@testtest.com',
            'password' => 'password123',
        ]);

        $response = $this->get('/item/1');
        $response->assertStatus(200);

        $postResponse = $this->post('/product/1/comment', [
            'comment' => 'test'
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => 2,
            'product_id' => 1,
            'comment' => 'test',
        ]);

        $postResponse = $this->post('/product/1/comment', [
            'comment' => ''
        ]);

        $postResponse->assertSessionHasErrors(['comment']);
        $errors = session('errors');
        $this->assertEquals('コメントを入力してください', $errors->first('comment'));

        $postResponse = $this->post('/product/1/comment', [
            'comment' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456'
        ]);

        $postResponse->assertSessionHasErrors(['comment']);
        $errors = session('errors');
        $this->assertEquals('255文字以内で入力してください', $errors->first('comment'));

        // 2.ログイン前のユーザーはコメントを送信できない
        $postResponse = $this->post('/logout');
        $response->assertStatus(200);

        $beforeCommentCount = Comment::where('product_id','=', '1')->count();

        $postResponse = $this->post('/product/1/comment', [
            'comment' => 'test'
        ]);
        $afterCommentCount = Comment::where('product_id','=', '1')->count();
        
        $this->assertEquals($beforeCommentCount, $afterCommentCount);
    }
}
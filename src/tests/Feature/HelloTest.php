<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class HelloTest extends TestCase
{
    use RefreshDatabase;

    public function testHello() {

        // $this->assertTrue(true);

        // $arr =[];
        // $this->assertEmpty($arr);

        // $txt = "Hello World";
        // $this->assertEquals('Hello World', $txt);

        // $n =random_int(0, 100);
        // $this->assertLessThan(100, $n);

            // $response = $this->get('/');
            // $response->assertStatus(200);

            // $response = $this->get('/no_route');
            // $response->assertStatus(404);

            // User::factory()->create([
            //         'name'=>'aaa',
            //         'email'=>'bbb@ccc.com',
            //         'password'=>'test12345'
            //     ]);
            //     $this->assertDatabaseHas('users',[
            //         'name'=>'aaa',
            //         'email'=>'bbb@ccc.com',
            //         'password'=>'test12345'
            //     ]);

            // 会員登録機能
            // 1. 名前が入力されていない場合
            $response = $this->get('/register');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/register', [
                'name' => '',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $postResponse->assertSessionHasErrors(['name']);

            $errors = session('errors');
            $this->assertEquals('お名前を入力してください', $errors->first('name'));

            // 2. メールアドレスが入力されていない場合
            $response = $this->get('/register');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/register', [
                'name' => 'テスト',
                'email' => '',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $postResponse->assertSessionHasErrors(['email']);

            $errors = session('errors');
            $this->assertEquals('メールアドレスを入力してください', $errors->first('email'));
   
            // 3. パスワードが入力されていない場合
            $response = $this->get('/register');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/register', [
                'name' => 'テスト',
                'email' => 'test@example.com',
                'password' => '',
                'password_confirmation' => 'password123',
            ]);

            $postResponse->assertSessionHasErrors(['password']);

            $errors = session('errors');
            $this->assertEquals('パスワードを入力してください', $errors->first('password'));

            // 4. パスワードが7文字以下の場合
            $response = $this->get('/register');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/register', [
                'name' => 'テスト',
                'email' => 'test@example.com',
                'password' => 'aaa',
                'password_confirmation' => 'password123',
            ]);

            $postResponse->assertSessionHasErrors(['password']);

            $errors = session('errors');
            $this->assertEquals('パスワードは8文字以上で入力してください', $errors->first('password'));

            // 5. パスワードが7文字以下パスワードが確認用パスワードと一致しない場合の場合
            $response = $this->get('/register');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/register', [
                'name' => 'テスト',
                'email' => 'test@example.com',
                'password' => 'aaaaaaaa',
                'password_confirmation' => 'password123',
            ]);

            $postResponse->assertSessionHasErrors(['password']);

            $errors = session('errors');
            $this->assertEquals('パスワードと一致しません', $errors->first('password'));

            // 6. 全ての項目が入力されている場合
            $response = $this->get('/register');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/register', [
                'name' => 'テスト',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $response->assertRedirect('/login/mypage/profile/register');
        }
}

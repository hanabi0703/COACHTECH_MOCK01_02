<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;

    public function test_example()
    {

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

            // 5. パスワードが確認用パスワードと一致しない場合の場合
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

            $postResponse->assertRedirect('/mypage/profile/register');
            
            // ログアウト機能
            // 1.ログアウトができる

            $this->assertAuthenticated();

            $postResponse = $this->post('/logout');
            $response->assertStatus(200);
            $this->assertGuest();

            // ログイン機能
            // 1. メールアドレスが入力されていない場合
            $response = $this->get('/login');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/login', [
                'email' => '',
                'password' => 'password123',
            ]);

            $postResponse->assertSessionHasErrors(['email']);

            // Fortyfyのデフォルトメッセージが変更できないため除外
            // $errors = session('errors');
            // $this->assertEquals('メールアドレスを入力してください', $errors->first('email'));

            // 2. パスワードが入力されていない場合
            $response = $this->get('/login');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => '',
            ]);

            $postResponse->assertSessionHasErrors(['password']);

            // Fortyfyのデフォルトメッセージが変更できないため除外
            // $errors = session('errors');
            // $this->assertEquals('パスワードを入力してください', $errors->first('email'));

            // 3. 入力情報が間違っている場合
            $response = $this->get('/login');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/login', [
                'email' => 'test@failed.com',
                'password' => 'password123',
            ]);

            $postResponse->assertSessionHasErrors(['email']);

            $errors = session('errors');
            $this->assertEquals('ログイン情報が登録されていません', $errors->first('email'));

            // 4. 正しい情報が入力された場合

            $user = \App\Models\User::factory()->create([
                'email' => 'test@testtest.com',
                'password' => Hash::make('password123'),
            ]);

            $response = $this->get('/login');
            $response->assertStatus(200);
    
            $postResponse = $this->post('/login', [
                'email' => 'test@testtest.com',
                'password' => 'password123',
            ]);

            $this->assertAuthenticatedAs($user);

    }
}

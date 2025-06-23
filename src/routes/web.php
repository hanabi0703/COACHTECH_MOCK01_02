<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);

Route::get('/item/{id}', [ProductController::class, 'productDetail'])->name('product.detail');

Route::middleware('auth')->group(function () {
    Route::get('/purchase/address/{id}', [ProductController::class, 'editAddress'])->name('purchase.address');
    Route::post('/purchase/{id}',
    [ProductController::class, 'updateAddress'])->name('product.purchase');
    Route::get('/purchase/{id}',
    [ProductController::class, 'purchase'])->name('product.purchase');
    Route::post('/buy', [ProductController::class, 'buy']);
    Route::get('/sell', [ProductController::class, 'sell']);
    Route::post('/sell', [ProductController::class, 'addProduct']);

    Route::post('/product/{id}/like', [ProductController::class, 'like'])->name('product.like');
    Route::post('/product/{id}/comment', [ProductController::class, 'comment'])->name('product.comment');

    Route::get('/mypage', [ProfileController::class, 'mypage']);
    Route::get('/mypage/profile', [ProfileController::class, 'profile']);
    Route::post('/mypage/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/mypage/profile/register', [ProfileController::class, 'registerProfile']);
});


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Like;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    public function index(){
        $products = Product::where('user_id','!=', Auth::id())->get();
        $likes = Like::where('likes.user_id','=', Auth::id())->join('products' ,'likes.product_id' ,'=', 'products.id')->get(); //Likes中間テーブルに基づいて商品テーブルから取得する
        return view('/index', compact('products', 'likes'));
    }


    public function search(Request $request)
    {
        $products = Product::KeywordSearch($request->keyword)->where('user_id','!=', Auth::id())->get();
        $product_ids = $products->pluck('id');
        $likes = DB::table('products')->joinSub(
            Like::where('likes.user_id','=', Auth::id())->whereIn('product_id', $product_ids),'likes', 'products.id', '=', 'likes.product_id')->get();
        return view('/index', compact('products', 'likes'));
    }

    public function sell(){
        $categories = Category::all();
        $conditions = Condition::all();
        return view('/sell', compact('categories', 'conditions'));
    }

    public function addProduct(ExhibitionRequest $request){
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        if(!empty($request->image)){
            $image_path = $request->file('image')->store('public/images');
            $product->image = basename($image_path);
        }
        $product->user_id = $request->user()->id;
        $product->description = $request->description;
        $product->condition_id = $request->condition_id;
        $product-> is_sold_out = '0';
        $product->save();
        $product->categories()->sync($request->category_ids);
        return redirect('/');
    }

    public function purchase(Request $request){
        $product = Product::find($request->id);
        $user = User::find($request->user()->id);
        $profile = Profile::where('user_id','=', $user->id)->first();
        return view('purchase', compact('product', 'user', 'profile'));
    }

    public function editAddress(Request $request){
        $product = Product::find($request->id);
        $user = User::find($request->user()->id);
        // Log::debug($user);
        return view('edit_address', compact('product', 'user'));
    }

    public function updateAddress(Request $request){
        $product = Product::find($request->id);
        $user = User::find($request->user()->id);
        $profile = Profile::where('user_id','=', $user->id)->first();
        if($request->post_code != null){
            $profile->post_code = $request->post_code;
        }
        if($request->address != null){
            $profile->address = $request->address;
        }
        if($request->building != null){
            $profile->building = $request->building;
        }
        return view('purchase', compact('product', 'user', 'profile'));
    }

    public function buy(PurchaseRequest $request){
        $purchase = new Purchase(); //purchaseテーブルを操作するのと同義となる
        $purchase->payment = $request->payment;
        $purchase->post_code = $request->post_code;
        $purchase->address = $request->address;
        $purchase->building = $request->building;
        $purchase->product_id = $request->id;
        $purchase->user_id = $request->user()->id;
        $purchase->save();
        $product = Product::find($request->id);
        $product->is_sold_out = '1';
        $product->save();
        $products = Product::where('user_id','!=', Auth::id())->get();
        $likes = Like::where('likes.user_id','=', Auth::id())->join('products' ,'likes.product_id' ,'=', 'products.id')->get();
        return view('index', compact('products', 'likes'));
    }

    public function productDetail(Request $request){
        $product = Product::find($request->id);
        $comments = Comment::where('product_id','=', $request->id)->get();
        $comments = Comment::where('comments.product_id','=', $request->id)->join('profiles' ,'comments.user_id' ,'=', 'profiles.user_id')->get();
        $categories = Category::all();
        $likeCount = Like::where('product_id', $request->id)->count();
        $commentCount = Comment::where('comments.product_id','=', $request->id)->count();
        if(Auth::user()) {
            $user = Auth::user();
            $isLiked = $user->likes()->where('product_id', $request->id)->exists();
        }
        else {
            $isLiked = '';
        }
        Log::debug($isLiked);
        return view('product', compact('product', 'categories', 'comments', 'likeCount', 'commentCount','isLiked'));
    }

    public function like(Request $request){
        $user = User::find($request->user()->id);
        $isLiked = $user->likes()->where('product_id', $request->id)->exists();
        if ($isLiked) {
        $user->likes()->detach($request->id);
        }
        else {
        $user->likes()->attach($request->id);
        }
        Log::debug($isLiked);
    return redirect()->route('product.detail', [
    'id' => $request->id, // ルートパラメータ
]);
    }

public function comment(CommentRequest $request)
    {
        $user = User::find($request->user()->id);
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->product_id = $request->id;
        $comment->user_id = $request->user()->id;
        $comment->save();
        return back();
    }
}
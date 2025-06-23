<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;

class ProfileController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $products = Product::where('user_id','=', $user->id)->get();
        $purchases = Purchase::where('purchases.user_id','=', $user->id)->join('products' ,'purchases.product_id' ,'=', 'products.id')->get();
        $profile = Profile::where('user_id','=', $user->id)->first();
        //内部結合によってpurchaseテーブルにproductテーブルを結合して取得
        return view('/profile', compact('user', 'products', 'purchases', 'profile'));
    }

    public function registerProfile()
    {
        $user = Auth::user();
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->image = 'default_icon.png';
        return view('/edit_profile', compact('user', 'profile'));
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id','=', $user->id)->first();
        return view('/edit_profile', compact('user', 'profile'));
    }

    public function updateProfile(AddressRequest $request)
    {
        if(Profile::where('user_id','=', $request->id)->first()){
            $form = Profile::where('user_id','=', $request->id)->first();
        }
        else {
            $form = new Profile();
            $form->user_id = $request->id;
            if(empty($request->image)) {
                $form->image = 'default_icon.png';
            }
        }
        $form->name = $request->name;
        if(!empty($request->image)) {
            $image_path = $request->file('image')->store('public/images');
            $form->image = basename($image_path);
        }
        $form->post_code = $request->post_code;
        $form->address = $request->address;
        $form->building = $request->building;
        $form->save();
        return redirect('/mypage');
    }
}

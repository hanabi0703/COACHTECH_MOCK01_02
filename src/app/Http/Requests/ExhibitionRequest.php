<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    
    return [
        'name' => 'required',
        'description' => 'required|max:255',
        'image' => 'required|mimes:jpg,png',
        'category_ids' => 'required',
        'condition_id' => 'required',
        'price' => 'required|integer|min:0'
    ];
    }

    public function messages()
    {
    return [
        'name.required' => '商品名を入力してください',
        'description.required' => '商品説明を入力してください',
        'image.required' => '商品画像を設定してください',
        'image.mimes' => '商品画像は.jpgか.pngで登録してください',
        'category_ids.required' => 'カテゴリーを設定してください',
        'condition_id.required' => '商品状態を設定してください',
        'price.required' => '販売価格を入力してください',
        'price.integer' => '数字で入力してください',
        'price.min' => '金額は０円以上で入力してください'

    ];
  }
}

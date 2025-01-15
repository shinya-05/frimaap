<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    // 認可の設定
    public function authorize()
    {
        // 必要に応じて認可ロジックを設定する（通常は true を返します）
        return true;
    }

    // バリデーションルールの定義
    public function rules()
    {
        return [
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'condition' => 'required|exists:conditions,id',
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    // カスタムメッセージ（任意）
    public function messages()
    {
        return [
            'categories.required' => 'カテゴリーを1つ以上選択してください。',
            'categories.*.exists' => '選択したカテゴリーが無効です。',
            'condition.required' => '商品の状態を選択してください。',
            'condition.exists' => '選択した商品の状態が無効です。',
            'title.required' => '商品名を入力してください。',
            'brand.required' => 'ブランド名を入力してください。',
            'description.required' => '商品の説明を入力してください。',
            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は数値で入力してください。',
            'product_image.image' => '画像ファイルをアップロードしてください。',
            'product_image.mimes' => '画像はjpeg, png, jpg, gif形式でアップロードしてください。',
        ];
    }
}

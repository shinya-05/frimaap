<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTradeMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証済みであればOK
    }

    public function rules()
    {
        return [
            'message' => 'required|string|max:400',
            'image'   => 'nullable|file|mimes:jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => '本文を入力してください',
            'message.max' => 'メッセージは400文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}

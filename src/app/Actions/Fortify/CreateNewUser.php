<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
//ユーザーのパスワードを安全に保存するためにハッシュ化
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Http\Requests\RegisterRequest;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input)
    {
        // RegisterRequestを利用したバリデーション
        $validator = Validator::make($input, (new RegisterRequest())->rules(), (new RegisterRequest())->messages());
        //第一引数：$input（ユーザー登録フォームから送られたデータ）
        //第二引数：(new RegisterRequest())->rules()（RegisterRequest で定義したルール）
        //第三引数：(new RegisterRequest())->messages()（RegisterRequest で定義したカスタムエラーメッセージ）
        $validator->validate(); // バリデーションを実行

        // バリデーション通過後にユーザー作成
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}

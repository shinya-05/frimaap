<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。',
            ])->withInput($request->except('password'));
    }

}
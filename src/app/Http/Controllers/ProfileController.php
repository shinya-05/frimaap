<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function setup ()
    {
        $user = Auth::user();
        return view('profile.setup', compact('user'));
    }

    public function completeSetup(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:500',
            'building_name' => 'nullable|string|max:255',
    ]);

        $user = Auth::user();

        // 画像の保存処理

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;

        }
        // ユーザー情報の更新

        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building_name = $request->input('building_name');
        $user->profile_completed = true;
        $user->save();

        return redirect()->route('home');
    }

}

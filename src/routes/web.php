<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


//未認証用
Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/item/:{id}', [ItemController::class, 'show'])->name('show');

//認証用
Route::middleware('auth', 'verified', 'first.login')->group(function () {
    Route::post('/item/{item}/comments', [ItemController::class, 'comment'])->name('comment');
    Route::post('/item/{item}/favorite', [ItemController::class, 'toggleFavorite'])->name('items.favorite');
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/purchase/:{item}', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/:{item}/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::post('/purchase/:{item}', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/address/:{item}', [PurchaseController::class, 'editAddress'])->name('purchase.addressEdit');
    Route::post('/purchase/address/:{item}', [PurchaseController::class, 'updateAddress'])->name('purchase.updateAddress');


});

//プロフィール設定
Route::get('/mypage/profile', [ProfileController::class, 'setup'])->name('profile.setup');
Route::post('/mypage/profile', [ProfileController::class, 'completeSetup'])->name('profile.complete');

//ログイン
Route::get('/login', [AuthController::class,'getLogin'])->name('login');;
Route::post('/login', [AuthController::class,'postLogin']);


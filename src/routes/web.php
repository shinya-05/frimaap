<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'first.login')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('home');
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::get('/mypage', [ProfileController::class, 'myPage']);
});

Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
Route::post('/profile/setup', [ProfileController::class, 'completeSetup'])->name('profile.complete');


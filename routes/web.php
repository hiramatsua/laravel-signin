<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    // サインイン前の処理
    // サインインしていないのに、ホーム画面にアクセスできないようにする。
    Route::middleware(['guest'])->group(function () {
        // ログインフォームの表示// サインイン フォームの表示
        Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
        // ログイン処理
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    // サインイン後の処理
    // 進む戻るで、サインインフォームに戻らないようにする。
    Route::middleware(['auth'])->group(function () {
        // ホーム画面
        Route::get('home', function () {
            return view('home');
        });
        // ログアウト画面
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Route::get('/user', [UserController::class, 'index']);


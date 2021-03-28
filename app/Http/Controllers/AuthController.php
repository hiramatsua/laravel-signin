<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // サインイン フォームの表示
    public function showLogin(){
        return view('login_form');
    }

    // ログインの処理
    public function login(LoginFormRequest $request){
    // バリデーションの処理 LoginFormRequest
    // Authの確認・実装処理
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    // home にリダイレクトさせる
            return redirect('home')
                ->with('login_success', 'サインインできました。');
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスまたはパスワードが間違っています。',
        ]);
    }

    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // ユーザーのセッション削除
        Auth::logout();
        // 全セッションの削除
        $request->session()->invalidate();
        // セッションを再生成する
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('logout', 'サインアウトしました。');
    }
}

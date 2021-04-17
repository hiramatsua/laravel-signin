<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // サインイン フォームの表示
    public function showLogin(){
        return view('login_form');
    }

    // ログインの処理、バリデーションの処理 LoginFormRequest、Authの確認・実装処理
    public function login(LoginFormRequest $request){
        $credentials = $request->only('email', 'password');
        // User情報を取得
        $user = User::where('email', '=', $credentials['email'])->first();
        // var_dump($user);
        // exit();
        if (!is_null($user)){
            // アカウントがロックされていたら・・
            if ($user->locked_flg === 1) {
                return back()->withErrors(['user_lock' => 'アカウントがロックされています。ログインできません。'
                ]);
            }
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // ログイン成功=>エラーアカウント０にする
                if ($user->error_count != 0) {
                    $user->error_count = 0;
                    $user->update();
                }
                // home にリダイレクトさせる
                return redirect('home')->with('success', 'サインインしました。');
            }
            // ログイン失敗したら、エラーアカウントを１増やす。
            $user->error_count = $user->error_count+1;
            // エラーアカウントが5以上の場合、アカウントをロックする。
            if ($user->error_count >= 5) {
                $user->locked_flg = 1;
                $user->update();
                return back()->withErrors(['user_lock' => 'アカウントがロックされました。'
                ]);
            }
            $user->update();
        }
        // User情報が取得できない NULL
        return back()->withErrors(['login_error' => 'メールアドレスまたはパスワードが間違っています。'
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

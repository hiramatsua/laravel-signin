<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;

class AuthController extends Controller
{
    // サインイン フォームの表示
    public function showLogin(){
        return view('login_form');
    }

    // loginの処理
    public function login(LoginFormRequest $request){
    // バリデーションの処理 LoginFormRequest
        
        dd($request->all());
    }
}

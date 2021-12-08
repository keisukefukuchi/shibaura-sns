<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Designer : 畑
 * Date     : 2021/06/14
 * Purpose  : C2-1 認証処理
 */

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Function Name : username
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 認証に利用するデータを指定
     * Return        : カラム名
     */
    public function username()
    {
         return 'student_number';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'student_number' => 'required|string',
            'password' => 'required|string',
        ], [
            'student_number.required' => '学籍番号を入力してください',
            'student_number.string' => '学籍番号には文字列を使用してください',
            'password.required' => 'パスワードを入力してください',
            'password.string' => 'パスワードには文字列を使用してください'
        ]);
    }

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

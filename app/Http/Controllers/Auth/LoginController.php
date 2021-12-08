<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;



class LoginController extends Controller
{

    use AuthenticatesUsers;


    
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

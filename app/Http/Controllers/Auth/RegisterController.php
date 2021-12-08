<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PreRegister;
use App\Models\PreUser;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Join;
use Illuminate\Support\Carbon;



class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function studentNumberVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_number' => 'required|string|unique:users,student_number|regex:/[a-z][a-z][0-9][0-9][0-9][0-9][0-9]/'
        ]);
        if ($validator->fails()) {
            return view('auth.register')->with([
                'email' => $request->email,
            ])->withErrors($validator);
        } else {
            $pre_user = PreUser::store($request->student_number);
            $email = new PreRegister($pre_user);
            Mail::to($request->student_number.'@shibaura-it.ac.jp')->send($email);

            return view('auth.pre_registered');
        }
    }

    public function studentNumberVerifyComplete($token)
    {
        $student_number_verification = PreUser::findByToken($token);

        if (empty($student_number_verification)
            || $student_number_verification->isRegister()
            || $student_number_verification->expiration_datetime < Carbon::now()){
            return view('error.register'); // エラーメッセージ
        }

        $student_number_verification->studentNumberVerify();

        return view('auth.main_register')->with([
            'token' => $student_number_verification->token
        ]);

    }

    protected function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'password' => 'required|string|min:8|max:16|confirmed',
        ]);
        if ($validator->fails()) {
            return view('auth.main_register')
                ->with([
                    'token' => $request->token,
                    'name' => $request->name,
                ])
                ->withErrors($validator);
        } else {
            $student_number_verification = PreUser::findByToken($request->token);
            $user = User::store(
                $request->name,
                $student_number_verification->student_number,
                Hash::make($request->password),
            );
            $student_number_verification->register();

            Auth::login($user);

            Join::join($user->id, 1);

            return redirect()->route('messages.index');
        }
    }
}

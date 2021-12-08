{{-- 仮登録完了画面 --}}
@extends('layouts.app')

@section('add_css')
    <link rel ="stylesheet" href="{{asset('/css/login.css')}}">
@endsection

@section('content')
    <p class="login_logo">Shibaura Chat System</p>
    <div class="registered_box">
        <p class="lead-text">仮会員登録完了！</p>
        <div class="registered_box_text">
            <p>
                この度は、ご登録いただき、誠にありがとうございます。
            </p>
            <p>
                ご本人様確認のため、ご登録いただいた学籍メールアドレスに、<br>
                本登録のご案内のメールが届きます。
            </p>
            <p>
                そちらに記載されているURLにアクセスし、<br>
                アカウントの本登録を完了させてください。
            </p>
        </div>
    </div>

@endsection

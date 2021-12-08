@extends('layouts.app')

@section('add_script')
<script src="{{ asset('js/logo.js') }}" defer></script>
@endsection

@section('add_css')
<link rel ="stylesheet" href="{{asset('/css/login.css')}}">
@endsection

@section('content')
        <p class="login_logo">Shibaura Chat System</p>
        <form method="POST" action="{{ route('main_register') }}" class="form">
            @csrf
            <p class="lead-text">本登録　必要事項を記入してください</p>
            <div class="register_form_wrap">
                <label for="name" class="form_label">名前</label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} form_input" name="name" value="{{ old('name') }}" placeholder="your name">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="register_form_wrap">
                <label for="password" class="form_label">パスワード(8文字以上16文字以下)</label>
                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} form_input" name="password" placeholder="password">
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="register_form_wrap">
                <label for="password-confirm" class="form_label">パスワード(確認用)</label>
                <input id="password-confirm" type="password" class="form-control form_input" name="password_confirmation" placeholder="password(again)">
            </div>
            <input type="hidden" name="token" value="{{ $token }}">
            <button type="submit" class="button">Sign up</button>
        </form>
@endsection

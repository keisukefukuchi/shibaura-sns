@extends('layouts.app')

@section('add_script')
<script src="{{ asset('js/logo.js') }}" defer></script>
@endsection

@section('add_css')
<link rel ="stylesheet" href="{{asset('/css/login.css')}}">
@endsection

@section('content')
    <p class="login_logo fade-in">Shibaura Chat System</p>
    <form method="POST" action="{{ route('login') }}" class="form">
        @csrf
        <div class="register_form_wrap">
            <label for="student_number" class="form_label">学籍番号</label>
            <input id="student_number" type="text" class="form-control @error('student_number') is-invalid @enderror form_input" name="student_number" value="{{ old('student_number') }}" placeholder="zz00000" autocomplete="student_number" autofocus>
            @error('student_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('student_number') }}</strong>
            </span>
            @enderror
        </div>

        <div class="register_form_wrap">
            <label for="password" class="form_label">パスワード</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror form_input" name="password" placeholder="password" autocomplete="current-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @enderror
        </div>



        <button type="submit" class="button">Login</button>


        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="login_form_link">
                まだアカウントをお持ちでない方はこちら
            </a>
        @endif
    </form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@endsection

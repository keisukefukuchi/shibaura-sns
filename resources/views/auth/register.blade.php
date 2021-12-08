{{-- 仮登録画面 --}}
@extends('layouts.app')

@section('add_css')
    <link rel ="stylesheet" href="{{asset('/css/login.css')}}">
@endsection

@section('content')
    <p class="login_logo">Shibaura Chat System</p>
    <form method="POST" action="{{ url('/pre_register') }}" class="form">
        @csrf
        <p class="lead-text">学籍番号を入力してください</p>
        <div class="register_form_wrap">
            <label for="student_number" class="form_label">学籍番号</label>
            <input id="student_number" type="text" class="form-control @error('student_number') is-invalid @enderror form_input" name="student_number" value="{{ old('student_number') }}" placeholder="zz00000" autocomplete="student_number" autofocus>
            @error('student_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('student_number') }}</strong>
            </span>
            @enderror
        </div>
        <button type="submit" class="button">Register</button>
    </form>
@endsection

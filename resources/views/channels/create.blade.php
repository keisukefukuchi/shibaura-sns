{{-- チャンネル作成画面 --}}
@extends('layouts.app')

@section('add_css')
<link rel ="stylesheet" href="{{asset('/css/style1_7.css')}}">
@endsection

@section('content')

        <div class="title">
            チャンネルを作成する
        </div>
        <div class="border"></div>
        <form action="{{ route('channels.store') }}"   method="POST">
            @csrf
            <div class="channelName">チャンネル名(20文字以内)</div>
                <input type="text" class="input @error('channel_name') is-invalid @enderror"  name="channel_name">

                @error('channel_name')
                    <span class="invalid-feedback" >
                        <br><strong class = "position">{{ $errors->first('channel_name') }}</strong>
                    </span>
                @enderror

            <div class="button">
                <input type="submit" value="＋ Create     ">
            </div>
        </form>

        <div class="button2">
            <a  href = "{{ route('channels.index') }}">
                <input type="submit" value="チャンネル一覧　＞">
            </a>
        </div>

        @endsection

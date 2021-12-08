{{-- チャンネル参加画面 --}}
@extends('layouts.app')

@section('add_css')
<link rel ="stylesheet" href="{{asset('/css/style1_9.css')}}">
@endsection

@section('content')

    <div class="title">
        チャンネル一覧
    </div>
    <div class="border"></div>

    @foreach ($channels as $channel)
        @if (in_array($channel->id, $join_channel_ids))
            <div class="channel">
                <form action="{{ route('leave') }}" method="POST">
                @csrf
                <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                    <div class="unjoinButton">
                        {{ '#'. $channel->channel_name }}
                        <input type="submit" value="退会する" >
                    </div>
                </form>
            </div>
        @else
        <div class="channel">
            <form action="{{ route('join') }}" method="POST">
            @csrf
            <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                <div class="joinButton">
                    {{ '#'. $channel->channel_name }}
                    <input type="submit" value="参加する" >
                </div>
            </form>
        </div>
        @endif
    @endforeach
    <p></p>
    <div class="page">
    {{ $channels->links() }}
    </div>

    <p></p>

@endsection

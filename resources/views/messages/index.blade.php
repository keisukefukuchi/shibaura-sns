{{-- メイン画面 --}}
@extends('layouts.app')
<style>
    .name {
        text-decoration: none;
        color: #000;
        font-size: 20px;
    }
    .wrapper {
        display: flex;
        justify-content: space-between;
        width: 80%
    }
    .a {
        margin: 0 auto;
    }
    .left {
        height: 700px;
    }
</style>

@section('content')
    <div class="row-m0 left">
        <div class="channel_bar vertical-scroll-table" style="height: 800px">
            <ul class="list-group list-group-flush">
                <p class="color list-group-item">参加チャンネル</p>
                <form method="POST" action="{{ url('messages/') }}" class="list-group list-group-flush">
                @foreach ($channels as $channel)
                        @csrf
                        @method('GET')
                        <button  type="submit" name="channel_id" value="{{ $channel->id }}" class="list-group-item list-group-item-action">{{ $channel->channel_name . "チャンネル"}}</button>
                @endforeach
                <p></p>
            </form>
                <a href="{{ url('channels/create') }}" class="list-group-item list-group-item-action"><i class="fas fa-plus" class="fa-fw"></i>　新規チャンネル作成</a>
                <a href="{{ url('users') }}" class="list-group-item list-group-item-action"><i class="fas fa-users" class="fa-fw"></i>　ユーザ一覧 </a>
            </ul>
        </div>

        <div class="col-9-lr15">
        @if (isset($timelines))
            <div class="vertical-scroll-table">
                <div class="list-group-item">
                    {{ $channel_name . "チャンネル"}}
                </div>
                @foreach ($timelines as $key => $timeline)
                    <div class="card timeline">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <div class="ml-2 d-flex flex-column">
                                <a class="mb-0 name" href="{{ url('users/' . $timeline->user->id) }}" class="text-secondary">{{ $timeline->user->name }}</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! nl2br(e($timeline->message)) !!}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            <div class="mr-3 d-flex align-items-center">
                                <a href="{{ url('messages/' . $timeline->id) }}">詳細</a>
                            </div>
                            <div class="mr-3 d-flex align-items-center">
                                <p class="mb-0 text-secondary"><i class="far fa-comment fa-fw"></i>{{ $timeline->getReplyCount($timeline->id) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <p></p>
                <div class="page">
                {{ $timelines->links() }}
                </div>
            </div>
        @endif
        <div class="wrapper">
            <div class="post-button">
                <a href="{{ url('messages/create/'.$channel_id) }}" class="list-group-item list-group-item-action"><i class="fas fa-pen" class="fa-fw"></i>　投稿</a>
            </div>
            <div class="search-button">
                <a href="{{ url('search') }}" class="list-group-item list-group-item-action"><i class="fas fa-search" class="fa-fw"></i>　検索</a>
            </div>
        </div>
        </div>

    </div>

@endsection



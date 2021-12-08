{{-- ユーザ詳細画面 --}}
@extends('layouts.app')

@section('add_css')
<link rel ="stylesheet" href="{{asset('/css/style1_11.css')}}">
@endsection

@section('content')
    <div class="profile">
        <div class="username">
            <div class="name"><b>{{ $user->name }}</b></div>
        </div>
        <div class="follow-list">

            <div class="center">
                <p >投稿数</p>
                <span>{{ $message_count }}</span>
            </div>
        </div>
    </div>

    <br>
    <br>

    <div class="row justify-content-center">
        @if (isset($timelines))
            @foreach ($timelines as $timeline)
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                <p class="mb-0">{{ $timeline->user->name }}</p>
                                <a href="{{ url('users/' .$timeline->user->id) }}" class="text-secondary">{{ $timeline->user->screen_name }}</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $timeline->message }}
                        </div>

                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                <p class="mb-0">{{ "#".$timeline->channel->channel_name }}</p>
                            </div>
                            <div class="mr-3 d-flex align-items-center">
                                <a href="{{ url('messages/' . $timeline->id) }}">詳細</a>
                            </div>

                            <!-- ここから -->
                            <div class="mr-3 d-flex align-items-center">
                                <p class="mb-0 text-secondary"><i class="far fa-comment fa-fw"></i>{{ $timeline->getReplyCount($timeline->id) }}</p>
                            </div>
                            <!-- ここまで -->

                        </div>
                    </div>
                </div>
            @endforeach
            <p></p>
            <div class="page">
            {{ $timelines->links() }}
            </div>
        @endif
    </div>
@endsection

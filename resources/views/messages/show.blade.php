{{-- チャット詳細画面 --}}
@extends('layouts.app')
<style>
    .name {
        text-decoration: none;
        color: #000;
        font-size: 20px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-haeder p-3 w-100 d-flex">
                    <div class="ml-2 d-flex flex-column">
                        <a class="mb-0 name" href="{{ url('users/' . $message->user->id) }}" class="text-secondary">{{ $message->user->name }}</a>
                    </div>
                    <div class="d-flex justify-content-end flex-grow-1">
                        <p class="mb-0 text-secondary">{{ $message->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                <div class="card-body">
                    {!! nl2br(e($message->message)) !!}
                </div>
                <div class="card-footer py-2 d-flex justify-content-end bg-white">

                    @if ($message->user->id === Auth::user()->id)
                        <div class="dropdown mr-3 d-flex align-items-center">
                            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-trash-alt fa-fw"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <form method="POST" action="{{ url('messages/' .$message->id) }}" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('messages/' . $message->id) }}" class="dropdown-item">キャンセル</a>
                                    <button type="submit" class="dropdown-item del-btn">削除</button>
                                </form>
                            </div>
                        </div>
                        <div class="mr-3 d-flex align-items-center">
                            <form method="POST" action="{{ url('messages/'.$message->id.'/edit') }}" class="mb-0">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn p-0 border-0"><i class="far fa-edit fa-fw"></i></button>
                            </form>
                        </div>
                    @endif
                    <div class="mr-3 d-flex align-items-center">
                        <form method="POST" action="{{ url('message/reply/'.$message->id) }}" class="mb-0">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn p-0 border-0"><i class="fas fa-reply"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">

        <div class="col-md-8 mb-3">

            <ul class="list-group">

                @forelse ($replies as $reply)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0 name">{{ $reply->user->name }}</p>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $reply->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! nl2br(($reply->message)) !!}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            <div class="mr-3 d-flex align-items-center">
                                <a href="{{ url('messages/' .$reply->id) }}">詳細</a>
                            </div>
                            <div class="mr-3 d-flex align-items-center">
                                <p class="mb-0 text-secondary"><i class="far fa-comment fa-fw"></i>{{ $reply->getReplyCount($reply->id) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <li class="list-group-item">
                        <p class="mb-0 text-secondary">返信はまだありません。</p>
                    </li>
                @endforelse
                <p></p>
                <div class="page">
                {{ $replies->links() }}
                </div>

            </ul>
        </div>
    </div>
</div>
@endsection

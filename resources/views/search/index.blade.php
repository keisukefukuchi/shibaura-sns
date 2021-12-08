{{-- 検索画面 --}}
@extends('layouts.app')
<style>
    .position {
        position: fixed;
        top: 60px;
        overflow:hidden;
        overflow-y:scroll;
        position: -webkit-sticky; /* safari対応 */
        height: 700px;
    }
</style>
@section('content')
    <div class="container">
        <div class='fixed-search' style="z-index: 99999999">
            <div class="col-md-12 py-4">
                <form action="search" method="POST" class="form-inline align-items-start">
                    @csrf
                    @method('GET')
                    <div class="container">
                        <div class="row d-flex">
                            <div class="flex-grow-1">
                                <input type="text" name="keyword" placeholder={{ $keyword }} class="form-control w-100">
                            </div>
                            <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 position">
            @foreach ($timelines as $timeline)
                <div class="card mt-4">
                    <div class="card-haeder p-3 w-100 d-flex">
                        <div class="ml-2 d-flex flex-column">
                            <p class="mb-0">{{ $timeline->user->name }}</p>
                        </div>
                        <div class="d-flex justify-content-end flex-grow-1">
                            <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! nl2br(e($timeline->message)) !!}
                    </div>
                    <div class="card-footer py-1 d-flex justify-content-end bg-white">
                        <div class="ml-2 d-flex flex-column flex-grow-1">
                            <p class="mb-0">{{ "#".$timeline->channel->channel_name }}</p>
                        </div>
                        <div class="mr-3 d-flex align-items-center">
                            <a href="{{ url('messages/' . $timeline->id) }}">詳細</a>
                        </div>
                        <div class="mr-3 d-flex align-items-center">
                            <p class="mb-0 text-secondary"><i class="far fa-comment fa-fw"></i>{{ $timeline->getReplyCount($timeline->id) }}</p>
                        </div>
                    </div>
                 </div>
             @endforeach
         </div>
    </div>
@endsection

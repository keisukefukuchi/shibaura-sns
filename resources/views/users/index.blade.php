{{-- ユーザ一覧画面 --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-haeder p-3 w-100 d-flex">
                        <div class="ml-2 d-flex flex-column">
                            <p class="mb-0">{{ "ユーザ一覧" }}</p>
                        </div>
                    </div>
                </div>
                <br>
                @foreach ($users as $user)
                    <a href="{{ url('users/' .$user->id) }}" class="list-group-item list-group-item-action my-1">{{ $user->name }}</a>
                @endforeach
                <p></p>
                <div class="page">
                {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">URLが無効です</div>

                <div class="card-body">
                    <p>
                        こちらのURLの有効期限が切れているか、<br>
                        既に登録を済ませている可能性があります。</p>
                    <p>
                        <br>【URLの有効期限が切れてしまっている方】<br>
                        再度仮登録からお試しください
                    </p>
                    <p>
                        <br>【既に登録を済ませている方】<br>
                        ログインからご利用ください
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

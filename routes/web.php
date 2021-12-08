<?php

use App\Http\Controllers\ChannelsController;
use App\Models\Channel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/messages');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 以下追加
Route::post('/pre_register', 'Auth\RegisterController@studentNumberVerification');

Route::get('/verify/{token}', 'Auth\RegisterController@studentNumberVerifyComplete')->where('token','[A-Za-z0-9]+');

Route::post('/main', 'Auth\RegisterController@create')->name('main_register');

// ログイン状態
Route::group(['middleware' => 'auth'], function() {

    // ユーザ関連
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update']]);

    // メッセージ関連
    Route::get('message/reply/{message_id}', 'MessagesController@reply');
    Route::post('reply/store', 'MessagesController@replyStore');

    Route::get('messages/create/{channel_id}', 'MessagesController@create');
    Route::resource('messages', 'MessagesController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

    Route::post('channels/join', 'ChannelsController@join')->name('join');
    Route::post('channels/leave', 'ChannelsController@leave')->name('leave');

    Route::resource('channels', 'ChannelsController', ['only' => ['index', 'store', 'create']]);

    Route::get('search', 'SearchController@index');

});

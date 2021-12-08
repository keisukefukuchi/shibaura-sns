<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Message;
use App\Models\Join;

/**
 * Designer : 畑
 * Date     : 2021/06/14
 * Purpose  : C2-3 利用者処理
 */

class UsersController extends Controller
{

    /**
     * Function Name : index
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 利用者一覧画面を表示する
     * Return        : 利用者一覧画面
     */
    public function index()
    {
        $users = User::getAllUsers(auth()->user()->id);
        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Function Name : show
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : プロフィール画面を表示する
     * Return        : プロフィール画面
     */
    public function show(User $user)
    {
        $join_channels = Join::joinChannelIds(auth()->user()->id);
        $timelines = Message::getUserTimeLine($user->id, $join_channels);
        $message_count = Message::getMessageCount($user->id);

        return view('users.show', [
            'user' => $user,
            'timelines' => $timelines,
            'message_count' => $message_count,
        ]);
    }

}

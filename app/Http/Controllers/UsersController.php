<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Message;
use App\Models\Join;



class UsersController extends Controller
{


    public function index()
    {
        $users = User::getAllUsers(auth()->user()->id);
        return view('users.index', [
            'users' => $users
        ]);
    }


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

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Join;



class ChannelsController extends Controller
{


    public function index()
    {
        $user = auth()->user();

        $join_channel_ids = Join::joinChannelIds($user->id);

        $channels = Channel::getChannels();

        return view('channels.index', [
            'join_channel_ids' => $join_channel_ids,
            'channels' => $channels
        ]);
    }


    public function create()
    {
        return view('channels.create');
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'channel_name' => 'required|string|max:20|unique:channels,channel_name',
        ]);
        $validator->validate();

        Channel::store($request->channel_name);

        $user = auth()->user();

        $join_channel_ids = Join::joinChannelIds($user->id);

        $channels = Channel::getChannels();

        return view('channels.index', [
            'join_channel_ids' => $join_channel_ids,
            'channels' => $channels
        ]);
    }


    public function join(Request $request)
    {
        $user = auth()->user();
        $channel_id = $request->channel_id;

        $is_join = Join::isJoin($user->id, $channel_id);

        if (!$is_join) {
            Join::join($user->id, $channel_id);
        }

        return back();
    }


    public function leave(Request $request)
    {
        $user = auth()->user();
        $channel_id = $request->channel_id;

        $is_join = Join::isJoin($user->id, $channel_id);

        if ($is_join) {
            Join::leave($user->id, $channel_id);
        }

        return back();
    }
}

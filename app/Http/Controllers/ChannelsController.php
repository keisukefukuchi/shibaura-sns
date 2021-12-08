<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Join;

/**
 * Designer : 畑
 * Date     : 2021/06/14
 * Purpose  : C5-1 チャンネル処理
 */

class ChannelsController extends Controller
{
    /**
     * Function Name : create
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : チャンネル参加画面を表示する
     * Return        : チャンネル参加画面
     */
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

    /**
     * Function Name : create
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : チャンネル作成画面を表示する
     * Return        : チャンネル作成画面
     */
    public function create()
    {
        return view('channels.create');
    }

    /**
     * Function Name : store
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : チャンネル作成処理を行う
     * Return        : チャンネル参加画面
     */
    public function store(Request $request)
    {
        // バリデータ
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

    /**
     * Function Name : join
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : チャンネル参加処理を行う
     * Return        : アクション前の画面
     */
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

    /**
     * Function Name : leave
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : チャンネル退会処理を行う
     * Return        : アクション前の画面
     */
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

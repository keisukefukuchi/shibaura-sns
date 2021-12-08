<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Models\Channel;
use App\Models\Join;

/**
 * Designer : 寺田
 * Date     : 2021/06/21
 * Purpose  : C3 チャット処理
 */

class MessagesController extends Controller
{
     /**
	 * Function Name	: index
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: メイン画面を表示する
	 * Return			: メイン画面
	 */
    public function index(Request $request, Message $message)
    {
        $user = auth()->user();
        $channel_id = $request->input('channel_id');
        if (empty($channel_id)){
            $channel_id = 1;
        }
        $timelines = $message->getTimelines($channel_id);
        $join_channels = Join::joinChannelIds($user->id);
        $channels = Channel::getJoinedChannels($join_channels);
        $channel = Channel::where('id', $channel_id)->first();
        $channel_name = $channel->channel_name;

        return view('messages.index', [
            'user'         => $user,
            'reply_id'     => 0,
            'timelines'    => $timelines,
            'channels'     => $channels,
            'channel_id'   => $channel_id,
            'channel_name' => $channel_name
        ]);
    }

    /**
    * Function Name	    : create
    * Designer			: 寺田
    * Date				: 2021/06/21
    * Function			: 投稿画面を表示する
    * Return			: 投稿画面
    */
    public function create($channel_id)
    {
        $user = auth()->user();
        $channel = Channel::where('id', $channel_id)->first();
        $channel_name = $channel->channel_name;

        return view('messages.create', [
            'user'          => $user,
            'reply_id'      => 0,
            'messages'      => null,
            'channel_name'  => $channel_name,
            'channel_id'    => $channel_id,
            'param'         => 0
        ]);
    }

    /**
	 * Function Name	: store
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: MessageテーブルをDBに保存する
	 * Return			: メイン画面
	 */
    public function store(Request $request, Message $message)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'message' => ['required', 'string', 'max:100']
        ]);
        $validator->validate();
        $message->messageStore($user->id, $data);

        return redirect('messages');
    }

    /**
	 * Function Name	: show
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: チャット詳細画面を表示する
	 * Return			: チャット詳細画面
	 */
    public function show(Message $message)
    {
        $user = auth()->user();
        $message = $message->getMessage($message->id);
        $reply = $message->getReply($message->id);

        return view('messages.show', [
            'user'    => $user,
            'message' => $message,
            'replies' => $reply,
        ]);
    }

    /**
	 * Function Name	: edit
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 編集するための投稿画面を表示する
	 * Return			: 投稿画面
	 */
    public function edit(Message $message)
    {
        $user = auth()->user();
        $messages = $message->getEditMessage($user->id, $message->id);

        if (!isset($messages)) {
            return redirect('messages');
        }

        return view('messages.create', [
            'user'          => $user,
            'reply_id'      => null,
            'message'       => $messages,
            'channel_name'  => $messages->channel->channel_name,
            'channel_id'    => null,
            'param'         => 1,
        ]);
    }

    /**
	 * Function Name	: update
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: メッセージ編集処理を行う
	 * Return			: メイン画面
	 */
    public function update(Request $request, Message $message)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'message' => ['required', 'string', 'max:100']
        ]);
        $validator->validate();
        $message->messageUpdate($message->id, $data);

        return redirect('messages');
    }

    /**
	 * Function Name	: destroy
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: メッセージ削除処理を行う
	 * Return			: メイン画面
	 */
    public function destroy(Message $message)
    {
        $user = auth()->user();
        $message->messageDestroy($user->id, $message->id);

        return redirect('messages');
    }

    /**
	 * Function Name	: reply
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 返信するための投稿画面を表示する
	 * Return			: 投稿画面
	 */
    public function reply($message_id)
    {
        $user = auth()->user();
        $message = Message::find($message_id);
        $channel_id = $message->channel_id;

        return view('messages.create', [
            'user'          => $user,
            'reply_id'      => $message_id,
            'message'       => $message,
            'channel_name'  => $message->channel->channel_name,
            'channel_id'    => $channel_id,
            'param'         => 2
        ]);
    }

    /**
	 * Function Name	: replyStore
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: MessageテーブルをDBに保存する
	 * Return			: メイン画面
	 */
    public function replyStore(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'message' => ['required', 'string', 'max:100']
        ]);
        $validator->validate();
        $message = new Message();
        $message->messageStore($user->id, $data);

        return redirect('messages');
    }

}

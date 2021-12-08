<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Models\Channel;
use App\Models\Join;


class MessagesController extends Controller
{
    public function index(Request $request, Message $message)
    {
        $user = auth()->user();
        $channel_id = $request->input('channel_id');
        if (empty($channel_id)) {
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

    public function destroy(Message $message)
    {
        $user = auth()->user();
        $message->messageDestroy($user->id, $message->id);

        return redirect('messages');
    }

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

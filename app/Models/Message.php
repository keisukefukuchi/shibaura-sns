<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Message extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assingnable.
     *
     * @var array
     */

    protected $fillable = [
        'message'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    public static function getUserTimeLine(Int $user_id, array $join_channel_ids)
    {
        return self::where('user_id', $user_id)->whereIn('channel_id', $join_channel_ids)->orderBy('created_at', 'DESC')->simplePaginate(50);
    }

    public static function getMessageCount(Int $user_id)
    {
        return self::where('user_id', $user_id)->count();
    }

    public function getReplyCount(Int $message_id)
    {
        return $this->where('reply_id', $message_id)->count();
    }

    public function getReply(Int $message_id)
    {
        return $this->where('reply_id', $message_id)->simplePaginate(50);
    }


    public function getTimeLines(Int $channel_id)
    {
        return $this->where('channel_id', $channel_id)->where('reply_id', 0)->orderBy('created_at', 'DESC')->simplePaginate(50);
    }


    public function getMessage(Int $message_id)
    {
        return $this->with('user')->where('id', $message_id)->first();
    }


    public function messageStore(Int $user_id, array $data)
    {
        $this->user_id = $user_id;
        $this->message = $data['message'];
        $this->reply_id = $data['reply_id'];
        $this->channel_id = $data['channel_id'];
        $this->save();

        return;
    }


    public function getEditMessage(Int $user_id, Int $message_id)
    {
        return $this->where('user_id', $user_id)->where('id', $message_id)->first();
    }


    public function messageUpdate(Int $message_id, array $data)
    {
        $this->id = $message_id;
        $this->message = $data['message'];
        $this->update();

        return;
    }


    public function messageDestroy(Int $user_id, Int $message_id)
    {
        return $this->where('user_id', $user_id)->where('id', $message_id)->delete();
    }


    public static function messagesSearch(string $keyword, array $join_channel_ids)
    {
        return self::whereIn('channel_id', $join_channel_ids)->where('message', 'like', '%' . $keyword . '%')->orderBy('created_at', 'DESC')->get();
    }
}

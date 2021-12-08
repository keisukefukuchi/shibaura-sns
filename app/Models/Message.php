<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Designer : 寺田
 * Date     : 2021/06/21
 * Purpose  : C7 チャット情報管理
 */

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

    /**
	 * Function Name	: user
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: Userクラスを返す
	 * Return			: Userクラスへの参照
	 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
	 * Function Name	: channel
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: Userクラスを返す
	 * Return			: Userクラスへの参照
	 */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
	 * Function Name	: getUserTimeLine
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 指定ユーザーIDのメッセージを取得する
	 * Return			: メッセージ
	 */
    public static function getUserTimeLine(Int $user_id, Array $join_channel_ids)
    {
        return self::where('user_id', $user_id)->whereIn('channel_id', $join_channel_ids)->orderBy('created_at', 'DESC')->simplePaginate(50);
    }

    /**
	 * Function Name	: getMessageCount
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 指定ユーザーIDに合致する投稿件数を取得する。
	 * Return			: Collection
	 */
    public static function getMessageCount(Int $user_id)
    {
        return self::where('user_id', $user_id)->count();
    }

    /**
     * Function Name	: getReplyCount
     * Designer			: 寺田
     * Date				: 2021/06/21
     * Function			: 指定ユーザーIDとメッセージIDに合致する返信件数を取得する。
     * Return			: Collection
     */
    public function getReplyCount(Int $message_id)
    {
        return $this->where('reply_id', $message_id)->count();
    }

    /**
	 * Function Name	: getReply
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 指定メッセージIDに合致する返信データを取得する。
	 * Return			: Collection
	 */
    public function getReply(Int $message_id)
    {
        return $this->where('reply_id', $message_id)->simplePaginate(50);
    }

    /**
	 * Function Name	: getTimeLines
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 指定チャンネルIDのメッセージリストを取得する
	 * Return			: メッセージリスト
	 */
    public function getTimeLines(Int $channel_id)
    {
        return $this->where('channel_id', $channel_id)->where('reply_id', 0)->orderBy('created_at', 'DESC')->simplePaginate(50);
    }

    /**
	 * Function Name	: getMessage
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 指定メッセージIDのMessageテーブルを取得する。
	 * Return			: Messageテーブル
	 */
    public function getMessage(Int $message_id)
    {
        return $this->with('user')->where('id', $message_id)->first();
    }

    /**
	 * Function Name	: messageStore
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 指定ユーザーIDのMessageテーブルをDBに保存する。
	 * Return			:
	 */
    public function messageStore(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->message = $data['message'];
        $this->reply_id = $data['reply_id'];
        $this->channel_id = $data['channel_id'];
        $this->save();

        return;
    }

    /**
	 * Function Name	: getEditMessage
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: 指定ユーザID、メッセージーIDに合致するMessageテーブルを取得する。
	 * Return			: Messageテーブル
	 */
    public function getEditMessage(Int $user_id, Int $message_id)
    {
        return $this->where('user_id', $user_id)->where('id', $message_id)->first();
    }

    /**
	 * Function Name	: messageUpdate
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: メッセージを更新する。
	 * Return			:
	 */
    public function messageUpdate(Int $message_id, Array $data)
    {
        $this->id = $message_id;
        $this->message = $data['message'];
        $this->update();

        return;
    }

    /**
	 * Function Name	: messageDestroy
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: メッセージを削除する。
	 * Return			: 削除結果
	 */
    public function messageDestroy(Int $user_id, Int $message_id)
    {
        return $this->where('user_id', $user_id)->where('id', $message_id)->delete();
    }

    /**
	 * Function Name	: messagesSearch
	 * Designer			: 寺田
	 * Date				: 2021/06/21
	 * Function			: メッセージを検索する。
	 * Return			: 検索結果
	 */
    public static function messagesSearch(string $keyword, Array $join_channel_ids)
    {
        return self::whereIn('channel_id', $join_channel_ids)->where('message', 'like', '%'.$keyword.'%')->orderBy('created_at', 'DESC')->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Designer : 畑
 * Date     : 2021/06/14
 * Purpose  : C8-2 チャンネル参加者情報管理
 */

class Join extends Model
{
    protected $fillable = [
        'user_id',
        'channel_id',
    ];

    public $timestamps = false;

    /**
     * Function Name : store
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 参加情報をデータベースに登録する
     * Return        : Join オブジェクト
     */
    public static function join(Int $user_id, Int $channel_id){
        $join = new self([
            'user_id'    => $user_id,
            'channel_id' => $channel_id
        ]);
        $join->save();
        return $join;
    }

    /**
     * Function Name : leave
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 参加情報をデータベースから削除する
     * Return        :
     */
    public static function leave(Int $user_id, Int $channel_id){
        $join = self::where('user_id', $user_id)->where('channel_id', $channel_id)->first();
        $join->delete();
    }

    /**
     * Function Name : JoinChannelIds
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 参加済のチャンネルID一覧を配列として返す
     * Return        : Collection
     */
    public static function joinChannelIds(Int $user_id)
    {
        $channel_ids = self::where('user_id', $user_id)->get('channel_id')->pluck('channel_id')->toArray();
        return $channel_ids;
    }

    /**
     * Function Name : isJoin
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 利用者がチャンネルに参加してるかどうか判定する
     * Return        : boolean
     */
    public static function isJoin(Int $user_id, Int $channel_id){
        $is_join = (boolean) self::where('user_id', $user_id)->where('channel_id', $channel_id)->first();
        return $is_join;
    }

}

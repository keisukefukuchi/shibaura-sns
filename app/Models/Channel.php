<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Designer : 畑
 * Date     : 2021/06/14
 * Purpose  : C8-1 チャンネル情報管理
 */

class Channel extends Model
{
    protected $fillable = [
        'channel_name',
    ];

    /**
     * Function Name : store
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : チャンネルデータを登録する
     * Return        : Channel
     */
    public static function store($channel_name)
    {
        $channel = new self([
            'channel_name'      => $channel_name
        ]);
        $channel->save();
        return $channel;
    }

    /**
     * Function Name : getJoinedChannels
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 参加済のチャンネルデータを取得する
     * Return        : Collection
     */
    public static function getJoinedChannels(Array $channel_ids)
    {
        $joined_channels = self::whereIn('id', $channel_ids)->orderBy('created_at')->get();
        return $joined_channels;
    }

    /**
     * Function Name : getChannels
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : main以外のすべてのチャンネルデータを取得する
     * Return        : Collection
     */
    public static function getChannels()
    {
        $channels = self::where('id' , '!=', 1)->simplePaginate(50);
        return $channels;
    }

}

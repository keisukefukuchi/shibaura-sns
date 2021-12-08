<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Join extends Model
{
    protected $fillable = [
        'user_id',
        'channel_id',
    ];

    public $timestamps = false;
    public static function join(Int $user_id, Int $channel_id){
        $join = new self([
            'user_id'    => $user_id,
            'channel_id' => $channel_id
        ]);
        $join->save();
        return $join;
    }
    public static function leave(Int $user_id, Int $channel_id){
        $join = self::where('user_id', $user_id)->where('channel_id', $channel_id)->first();
        $join->delete();
    }

    public static function joinChannelIds(Int $user_id)
    {
        $channel_ids = self::where('user_id', $user_id)->get('channel_id')->pluck('channel_id')->toArray();
        return $channel_ids;
    }


    public static function isJoin(Int $user_id, Int $channel_id){
        $is_join = (boolean) self::where('user_id', $user_id)->where('channel_id', $channel_id)->first();
        return $is_join;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Channel extends Model
{
    protected $fillable = [
        'channel_name',
    ];

    public static function store($channel_name)
    {
        $channel = new self([
            'channel_name'      => $channel_name
        ]);
        $channel->save();
        return $channel;
    }

    public static function getJoinedChannels(Array $channel_ids)
    {
        $joined_channels = self::whereIn('id', $channel_ids)->orderBy('created_at')->get();
        return $joined_channels;
    }

    public static function getChannels()
    {
        $channels = self::where('id' , '!=', 1)->simplePaginate(50);
        return $channels;
    }

}

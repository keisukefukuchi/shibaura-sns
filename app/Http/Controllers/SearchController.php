<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Join;



class SearchController extends Controller
{

    public function index(Request $request){
        $user = auth()->user();
        $join_channels = Join::joinChannelIds($user->id);
        $keyword = $request->keyword;

        if(!empty($keyword)){
            $timelines = Message::messagesSearch($keyword, $join_channels);
            return view('search.index', [
                'user' => $user,
                'timelines' => $timelines,
                'keyword' => $keyword
            ]);
        }

        return view('search.index', [
            'user' => $user,
            'timelines' => [],
            'keyword' => '検索ワード'
        ]);
    }
}

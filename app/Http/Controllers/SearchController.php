<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Join;

/**
 * Designer : 畑
 * Date     : 2021/06/14
 * Purpose  : C4-1 検索処理
 */

class SearchController extends Controller
{
    /**
     * Function Name : index
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 検索画面及び、検索結果を表示する
     * Return        : 検索画面、検索結果
     */
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

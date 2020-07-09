<?php

namespace App\Http\Controllers\Douyin;

use App\Http\Controllers\Controller;
use App\Models\Douyin\Video;
use App\Util\Douyin\WebApi;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $videos = Video::query()
            ->orderByDesc('create_time')
            ->paginate(12)
            ->appends($request->all());

        return view('douyin.video.index', compact('videos'));
    }

    //公开/隐藏视频
    public function visibility(Video $video, WebApi $api)
    {
        //更改视频信息
        $api->videoUpdate($video->dyuser, [
            'item_id' => $video->aweme_id,
            'visibility_type' => (int)!$video->is_private
        ]);

        //获取视频信息并更新
        Video::createByApi($api->getVideoInfo($video));

        return back();
    }
}

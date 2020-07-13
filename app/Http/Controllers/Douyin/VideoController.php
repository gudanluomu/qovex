<?php

namespace App\Http\Controllers\Douyin;

use App\Http\Controllers\Controller;
use App\Jobs\DouyinVideoGetPodcast;
use App\Models\Douyin\Video;
use App\Util\Douyin\VideoUpdateRequest;
use Illuminate\Http\Request;
use App\Util\Douyin\Request as ApiRequest;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $videos = Video::query()
            ->with('products')
            ->orderByDesc('create_time')
            ->paginate(12)
            ->appends($request->all());

        return view('douyin.video.index', compact('videos'));
    }

    //公开/隐藏视频
    public function visibility(Video $video, ApiRequest $apiRequest)
    {
        $re = new VideoUpdateRequest();

        $re->setFormParams([
            'item_id' => $video->aweme_id,
            'visibility_type' => (int)!$video->is_private
        ]);

        //更改视频信息
        $apiRequest->request($re, $video->dyuser);

        //确认已更改
        $video->updateSelfByApi();

        return back();
    }
}

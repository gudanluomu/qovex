<?php

namespace App\Http\Controllers\Douyin;

use App\Http\Controllers\Controller;
use App\Jobs\DouyinVideoGetPodcast;
use App\Models\Douyin\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $videos = Video::query()
            ->with('dyuser:uid,nickname')
            ->orderByDesc('create_time')
            ->paginate(12)
            ->appends($request->all());

        return view('douyin.video.index', compact('videos'));
    }
}

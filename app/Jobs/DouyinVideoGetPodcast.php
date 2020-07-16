<?php

namespace App\Jobs;

use App\Models\Douyin\User;
use App\Models\Douyin\Video;
use App\Util\Douyin\GetVideoListRequest;
use App\Util\Douyin\Request;
use App\Util\Douyin\WebApi;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DouyinVideoGetPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $request = new Request();

        $api = new GetVideoListRequest();

        //遍历视频列表
        foreach (Arr::get($request->request($api, $this->user), 'aweme_list', []) as $v) {
            Video::createByApi($v, $this->user);
        }
    }


}

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

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function handle()
    {
        if (is_null($this->user)) {
            $users = User::query()->where('cookie_status', true)->get(['id', 'cookie', 'group_id', 'user_id', 'department_id']);
        } else {
            if ($this->user instanceof Collection) {
                $users = $this->user;
            } else {
                $users = collect([$this->user]);
            }
        }

        $request = new Request();

        $api = new GetVideoListRequest();

        //并发获取账号视频列表 返回数据格式 user_id=>[接口response]
        $request->request($api, $users)->each(function ($response, $user_id) use ($users) {
            //根据key获取抖音账号
            $user = $users->where('id', $user_id)->first();
            //没找到员工
            if (is_null($user)) return;

            //遍历视频列表
            foreach (Arr::get($response, 'aweme_list', []) as $v) {
                Video::createByApi($v, $user);
            }
        });
    }


}

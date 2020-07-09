<?php

namespace App\Jobs;

use App\Models\Douyin\User;
use App\Models\Douyin\Video;
use App\Util\Douyin\WebApi;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class DouyinVideoGetPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle()
    {
        $users = User::query()->where('cookie_status', true)->get(['id', 'cookie', 'group_id', 'user_id', 'department_id']);

        $api = new WebApi();

        //并发获取账号视频列表 返回数据格式 user_id=>[接口response]
        $api->getVideoList($users)->each(function ($response, $user_id) use ($users) {
            //根据key获取抖音账号
            $user = $users->where('id', $user_id)->first();
            //没找到员工
            if (is_null($user)) return;

            //遍历视频列表
            foreach (Arr::get($response, 'aweme_list', []) as $v) {
                Video::create($v, $user);
            }
        });
    }


}

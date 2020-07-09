<?php


namespace App\Util\Douyin;


use App\Exceptions\ApiRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class WebApi
{
    //个人信息
    public function getUserInfo(UserContract $user)
    {
        $url = 'https://creator.douyin.com/web/api/media/user/info/?';

        $query = [
            'cookie_enabled' => 'true',
            'screen_width' => '1920',
            'screen_height' => '1080',
            'browser_language' => 'zh-CN',
            'browser_platform' => 'Win32',
            'browser_name' => 'Mozilla',
            'browser_version' => '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
            'browser_online' => 'true',
            'timezone_name' => 'Asia/Shanghai',
        ];

        $options = [
            'query' => $query,

            'headers' => [
                'Cookie' => $user->getCookie()
            ],
        ];

        $res = json_decode((new Client())->request('get', $url, $options)->getBody()->getContents(), 1);

        if ($user = Arr::get($res, 'user')) return $user;

        throw new ApiRequestException('用户信息获取失败', $res);
    }

    //pid
    public function getPid(UserContract $user)
    {
        $url = 'https://lianmeng.snssdk.com/user/subpid/getUserPidInfo/?';

        $query = [
            'b_type_new' => '2',
            'os' => 'android',
            'pid_type' => '1',
            'bind_platform' => '1',
            'is_vcd' => '1',
            'aid' => '1128',
        ];

        $options = [
            'query' => $query,
            'headers' => [
                'Cookie' => $user->getCookie(),
            ],
        ];

        $res = json_decode((new Client())->request('get', $url, $options)->getBody()->getContents(), 1);

        return Arr::get($res, 'data.sub_pid');

    }

    //视频列表
    public function getVideoList($user, $max_cursor = 0, $count = 10, $status = 1)
    {
        $url = 'https://creator.douyin.com/web/api/media/aweme/post/';

        $query = [
            'scene' => 'mix',
            'status' => $status,
            'count' => $count,
            'min_cursor' => 0,
            'max_cursor' => $max_cursor,
            'cookie_enabled' => true,
            'screen_width' => '1920',
            'screen_height' => '1080',
            'browser_language' => 'zh-CN',
            'browser_platform' => 'Win32',
            'browser_name' => 'Mozilla',
            'browser_version' => '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
            'browser_online' => true,
            'timezone_name' => 'Asia/Shanghai',
            'aid' => 1128,
        ];

        if ($user instanceof Collection) {
            //并发
            $client = new Client(['base_uri' => $url, 'query' => $query]);

            $promises = [];

            $user->each(function (UserContract $user) use (&$promises, $client) {
                $promises[$user->id] = $client->getAsync(null, [
                    'headers' => [
                        'Cookie' => $user->getCookie(),
                        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36'
                    ]
                ]);
            });

            $results = Promise\unwrap($promises);

            return collect($results)->map(function ($item) {
                return json_decode($item->getBody()->getContents(), 1);
            });

        } else {
            //单个账号
            $options = [
                'query' => $query,

                'headers' => [
                    'Cookie' => $user->getCookie()
                ],
            ];

            $res = json_decode((new Client())->request('get', $url, $options)->getBody()->getContents(), 1);

            if ($data = Arr::get($res, 'user')) return $data;

            throw new ApiRequestException("`{$user->getNick()}`" . '视频信息获取失败', $res);
        }


    }
}

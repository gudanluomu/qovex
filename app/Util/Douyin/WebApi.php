<?php


namespace App\Util\Douyin;


use App\Exceptions\ApiRequestException;
use App\Models\Douyin\Video;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Promise;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class WebApi
{
    //个人信息
    public function getUserInfo(UserContract $user)
    {
        $url = 'https://creator.douyin.com/web/api/media/user/info/?';

        $query = $this->getWebQuery();

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
    public function getVideoList($user, $max_cursor = 0, $count = 10, $min_cursor = 0, $status = 1)
    {
        $url = 'https://creator.douyin.com/web/api/media/aweme/post/';

        $query = array_merge($this->getWebQuery(), [
            'scene' => 'mix',
            'status' => $status,
            'count' => $count,
            'min_cursor' => $min_cursor,
            'max_cursor' => $max_cursor,
        ]);

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

            if ($res['status_code'] === 0) {
                return $res;
            }

            throw new ApiRequestException("`{$user->getNick()}`" . '视频信息获取失败', $res);
        }


    }

    //获取单条视频信息
    public function getVideoInfo(Video $video)
    {
        $max_cursor = ($video->create_time + 1) . '000';
        $min_cursor = ($video->create_time - 1) . '000';

        $res = $this->getVideoList($video->dyuser, $max_cursor, 1, $min_cursor);

        $newVideo = collect(Arr::get($res, 'aweme_list'))->where('aweme_id', $video->aweme_id)->first();

        if ($newVideo) {
            return $newVideo;
        }

        throw new ApiRequestException($video->aweme_id . '视频未找到', $video->toArray());
    }

    //更新视频信息
    public function videoUpdate(UserContract $user, $form_params = [])
    {
        $url = 'https://creator.douyin.com/web/api/media/aweme/update/';

        $query = $this->getWebQuery();

        $options = [
            'query' => $query,
            'form_params' => $form_params,
            'headers' => [
                'Cookie' => $user->getCookie() . ";csrf_token=123123;",
                'x-csrf-token' => "123123",
            ],
        ];

        $res = json_decode((new Client())->request('post', $url, $options)->getBody()->getContents(), 1);

        if ($res['status_code'] === 0) {
            return true;
        }

        throw new ApiRequestException('视频隐藏/公开失败', $res);
    }

    //dou+余额
    public function getDouplusRefundInfo(UserContract $user)
    {
        $url = 'https://aweme.snssdk.com/aweme/v2/douplus/refund/info/';

        $options = [
            'query' => [
                'aid' => '1128',
            ],
            'headers' => [
                'Cookie' => $user->getCookie()
            ]
        ];


        $res = json_decode((new Client())->request('post', $url, $options)->getBody()->getContents(), 1);

        if ($res['status_code'] === 0) {
            return $res;
        }

        throw new ApiRequestException('可退余额获取失败', $res);
    }

    //
    public function douplusOrderCreate(UserContract $payUser, Video $video, $params, $total = 1)
    {

        $url = 'https://aweme.snssdk.com/aweme/v2/douplus/order/create/?';

        $query = [
            'item_id' => $video->aweme_id,
            'pay_type' => 1,
            '_rticket' => '123456789',
            'device_platform' => 'android',
            'aid' => '1128',
        ];

        $query = array_merge($query, $params);

        $url .= http_build_query($query);

        $xg = $this->getXg($url);

        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $xg['url'], [
            'Cookie' => $payUser->getCookie(),
            'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 8.1.0; zh_CN; Redmi 6A; Build/O11019; Cronet/58.0.2991.0)',
            'X-Khronos' => $xg['khronos'],
            'X-Gorgon' => $xg['gorgon'],
        ]);

        $requests = function ($total, $request) {
            for ($i = 0; $i < $total; $i++) {
                yield $request;
            }
        };

        $real_num = 0;

        $contents = [];

        $pool = new Pool($client, $requests($total, $request), [
            'concurrency' => 50,

            'fulfilled' => function ($response) use (&$real_num, &$contents) {

                $content = json_decode($response->getBody()->getContents(), 1);

                $contents[] = $content;

                if (Arr::get($content, 'status_code') == 0) {
                    $real_num++;
                }
            }
        ]);
        //启动
        $promise = $pool->promise();
        //执行
        $promise->wait();

        return compact('real_num', 'contents');

    }

    public function getXg($url)
    {
        return json_decode((new Client())->request('get', '47.114.43.205:47107/api?url=' . urlencode($url))->getBody()->getContents(), 1);
    }

    //weiAPI公用query
    protected function getWebQuery()
    {
        return [
            'cookie_enabled' => true,
            'screen_width' => '1920',
            'screen_height' => '1080',
            'browser_language' => 'zh-CN',
            'browser_platform' => 'Win32',
            'browser_name' => 'Mozilla',
            'browser_version' => '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
            'browser_online' => true,
            'timezone_name' => 'Asia/Shanghai',
            'aid' => '1128',
        ];
    }
}

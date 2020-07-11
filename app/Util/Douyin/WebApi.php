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
    public $client;
    public $xg;

    public function __construct()
    {
        $this->client = new Client();
        $this->xg = new Request();
    }

    //dou+投放
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

    //dou+订单列表
    public function douplusAdList(UserContract $user, $page = 1, $limit = 10)
    {
        $url = 'https://aweme.snssdk.com/aweme/v2/douplus/ad/list/';

        $options = [
            'query' => [
                'page' => $page,
                'limit' => $limit,
                'pay_status' => 0,
            ],
            'headers' => [
                'Cookie' => $user->getCookie(),
                'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 8.1.0; zh_CN; Redmi 6A; Build/O11019; Cronet/58.0.2991.0)',
            ]
        ];

        $res = $this->xg->xgRequest($url, $options);

        if (Arr::get($res, 'status_code') == 0) {
            return $res;
        }

        throw new ApiRequestException('豆荚订单列表获取失败', $res);
    }

}

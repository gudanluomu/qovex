<?php


namespace App\Util\Douyin;


use App\Exceptions\ApiRequestException;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

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

        $pid = Arr::get($res, 'data.sub_pid');

        if ($pid) return $pid;

        throw new ApiRequestException('推广位获取失败', $res);
    }
}

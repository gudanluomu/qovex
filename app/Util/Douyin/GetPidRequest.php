<?php


namespace App\Util\Douyin;


use Illuminate\Support\Arr;

class GetPidRequest extends AppRequest
{
    public function url(): string
    {
        return 'https://lianmeng.snssdk.com/user/subpid/getUserPidInfo/';
    }

    public function options(): array
    {
        return [
            'query' => [
                'b_type_new' => 2,
                'os' => 'android',
                'pid_type' => 1,
                'bind_platform' => 1,
                'aid' => 1128,
            ]
        ];
    }

    public function verifyResponse($res)
    {
        if ($res && isset($res['code']) && $res['code'] == 0) {
            return Arr::get($res, 'data.sub_pid');
        }

        return false;
    }
}

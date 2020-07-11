<?php


namespace App\Util\Douyin;


abstract class WebRequest implements RequestContract
{
    public function comQuery(): array
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

    public function method(): string
    {
        return 'get';
    }

    public function verifyResponse($res)
    {
        if ($res && isset($res['status_code']) && $res['status_code'] == 0) {
            return $res;
        }

        return false;
    }

    public function isRisk(): bool
    {
        return false;
    }

    public function getCookie(UserContract $user)
    {
        return $user->getCookie();
    }

}

<?php


namespace App\Util\Douyin;


class GetUserInfoRequest extends WebRequest
{
    public function url(): string
    {
        return 'https://creator.douyin.com/web/api/media/user/info/';
    }

    public function options(): array
    {
        return [
            'query' => $this->comQuery(),
        ];
    }

    public function verifyResponse($res)
    {
        if ($res && isset($res['status_code']) && $res['status_code'] == 0) {
            return $res['user'];
        }

        return false;
    }
}

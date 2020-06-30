<?php


namespace App\Util\Taobao;


class TpwdCreateRequest implements RequestContract
{
    public function getApiMethodName(): string
    {
        return 'taobao.tbk.tpwd.create';
    }

    public function getApiFormParams(): array
    {
        return [
            'text' => '测试淘口令',
            'url' => 'https://uland.taobao.com/',
        ];
    }
}

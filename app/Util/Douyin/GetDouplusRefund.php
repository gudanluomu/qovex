<?php


namespace App\Util\Douyin;


use Illuminate\Support\Arr;

class GetDouplusRefund extends AppRequest
{
    public function url(): string
    {
        return 'https://aweme.snssdk.com/aweme/v2/douplus/refund/info/';
    }

    public function options(): array
    {
        return [
            'query' => [
                'aid' => 1128,
            ]
        ];
    }
}

<?php


namespace App\Util\Douyin;


use Illuminate\Support\Arr;

class DouplusOrderCreate extends AppRequest
{
    public $query = [
        'pay_type' => 1,
        'device_platform' => 'android',
        'aid' => 1128,
    ];

    public function url(): string
    {
        return 'https://aweme.snssdk.com/aweme/v2/douplus/refund/info/';
    }

    public function options(): array
    {
        return [
            'query' => $this->query,
            'headers' => [
                'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 8.1.0; zh_CN; Redmi 6A; Build/O11019; Cronet/58.0.2991.0)',
            ]
        ];
    }

    public function setQuery($query)
    {
        $this->query = array_merge($this->query, $query);

        return $this;
    }

    public function isRisk(): bool
    {
        return true;
    }
}

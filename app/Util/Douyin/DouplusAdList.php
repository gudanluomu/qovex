<?php


namespace App\Util\Douyin;


class DouplusAdList extends AppRequest
{
    public $query = [
        'page' => 1,
        'limit' => 20,
        'pay_status' => 0,
    ];

    public function url(): string
    {
        return 'https://aweme.snssdk.com/aweme/v2/douplus/ad/list/';
    }

    public function options(): array
    {
        return [
            'query' => array_merge($this->comQuery(), $this->query),
            'headers' => [
                'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 8.1.0; zh_CN; Redmi 6A; Build/O11019; Cronet/58.0.2991.0)',
            ]
        ];
    }

    public function setQuery($page)
    {
        $this->query['page'] = $page;

        return $this;
    }

    public function isRisk(): bool
    {
        return true;
    }
}

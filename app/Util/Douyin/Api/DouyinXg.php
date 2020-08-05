<?php


namespace App\Util\Douyin\Api;


class DouyinXg extends BaseApi
{
    public $url = '47.114.43.205:47107/api';

    public function __construct($requestUrl)
    {
        parent::__construct();

        $this->setQuery('url', $requestUrl);
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}

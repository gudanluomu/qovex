<?php


namespace App\Util\Douyin\Api;

use GuzzleHttp\Pool;

class DouplusOrderStatByItem extends BaseApi
{
    public $url = 'https://api-hl.amemv.com/aweme/v2/douplus/order/stat/by/item/';

    public $item_ids;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setItemIds(array $item_ids)
    {
        $this->item_ids = $item_ids;
        return $this;
    }

    public function allRequest($onFulfilled = null, $onRejected = null)
    {
        $pool = new Pool($this->client, $this->getRequests(), [
            'concurrency' => 20,
            'fulfilled' => $onFulfilled,
            'rejected' => $onRejected,
        ]);

        //启动
        $promise = $pool->promise();
        //执行
        $promise->wait();
    }

    public function getRequests()
    {
        foreach ($this->item_ids as $item_id) {
            $this->setQuery('item_id', $item_id);
            yield $item_id => new \GuzzleHttp\Psr7\Request(
                $this->getMethod(),
                $this->getQueryUrl(),
                $this->getHeaders());
        }
    }
}

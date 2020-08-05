<?php


namespace App\Util\Douyin\Api;

use Psr\Http\Message\ResponseInterface;

class DouplusOrderItemList extends BaseApi
{
    public $url = 'https://api-hl.amemv.com/aweme/v2/douplus/order/item/list/';

    public $query = [
        'page' => 1,
        'limit' => 50,
    ];

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setPage($page)
    {
        return $this->setQuery('page', $page);
    }

    public function nextPage()
    {
        return $this->setQuery('page', $this->query['page']++);
    }

}

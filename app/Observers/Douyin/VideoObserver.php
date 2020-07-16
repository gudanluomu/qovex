<?php

namespace App\Observers\Douyin;

use App\Models\Douyin\Video;
use App\Models\Product;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class VideoObserver
{

    public function created(Video $video)
    {
        //获取商品信息
        if ($video->isWithGoods()) {

            (new Client(['synchronous' => true]))
                ->requestAsync('GET', 'https://api-hl.amemv.com/aweme/v2/shop/promotion/?aid=1128&aweme_id=' . $video->aweme_id)
                ->then(function (ResponseInterface $res) use ($video) {

                    $promotions = json_decode(json_decode($res->getBody()->getContents(), 1)['promotion'], 1);
                    $product = collect([]);

                    foreach ($promotions as $v) {
                        $product->push(Product::createByApi($v, $video));
                    }

                    $video->products()->attach($product->pluck('product_id'));

                    $video->product_type = $product->first()->goods_type;
                    $video->save();
                });
        }
    }
}

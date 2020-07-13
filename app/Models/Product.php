<?php

namespace App\Models;

use App\Models\Douyin\Video;
use App\Scopes\RuleScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Product extends Model
{
    protected $fillable = [
        'product_id', 'promotion_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RuleScope());
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class,
            'video_has_product',
            'pid',
            'vid',
            'product_id',
            'aweme_id');
    }

    public static function createByApi($data, Video $video)
    {
        $attr = [
            'group_id' => $video->group_id
        ];

        $field = [
            'promotion_id',
            'product_id',
            'title',
            'market_price',
            'price',
            'detail_url',
            'sales',
            'images' => 'images.0.url_list.0',
            'status',
            'promotion_source',
            'cos_fee',
            'goods_source'
        ];

        foreach ($field as $k => $v) {
            if (is_numeric($k)) $k = $v;
            $attr[$k] = Arr::get($data, $v);
        }

        $product = Product::query()->firstOrNew(Arr::only($attr, ['product_id', 'promotion_id']));

        $product->forceFill($attr)->save();

        return $product;
    }
}

<?php

namespace App\Models\Douyin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class VideoAd extends Model
{
    protected $table = 'douyin_video_ads';

    protected $fillable = [
        'pay_user_id',
        'aweme_id',
    ];

    public static function createByApi($data, $aweme_id, User $payUser)
    {

        $ad = static::query()
            ->firstOrNew([
                'pay_user_id' => $payUser->uid,
                'aweme_id' => $aweme_id
            ]);

        $attr = [];

        $field = [
            'add_cart_clicks',
            'applet_click',
            'budget',
            'business_tab_show',
            'click_want_count',
            'comments',
            'consult_clicks',
            'cost',
            'fans',
            'go_shop_clicks',
            'home_page_clicks',
            'homepage_applet_click',
            'homepage_down_click',
            'homepage_link_click',
            'homepage_message_click',
            'homepage_phone_click',
            'likes',
            'live_click',
            'order_type',
            'plays',
            'poi_clicks',
            'product_real_amount',
            'product_real_orders',
            'product_toal_amount',
            'product_total_orders',
            'serve_tab_click',
            'shares',
            'shop_visit_count',
            'shop_window_click',
            'shopping_clicks',
            'vote_clicks',
        ];

        foreach ($field as $k => $v) {
            if (is_numeric($k)) $k = $v;
            $attr[$k] = str_replace(',', '', Arr::get($data[0], $v));
        }

        //查找视频
        $video = Video::query()
            ->where(['aweme_id' => $aweme_id])
            ->first(['aweme_id', 'author_user_id', 'group_id', 'user_id', 'department_id']);

        if (is_null($video)) return null;

        //新视频
        if (!$ad->exists) {
            $ad->group_id = $video->group_id;
            $ad->user_id = $video->user_id;
            $ad->department_id = $video->department_id;
            $ad->aweme_author_id = $video->author_user_id;
        }

        /**
         * 写入条件
         * 不存在
         * 只记录总计
         *
         */
        if (!$ad->exists || ($ad->cost < $attr['cost'] && $data[0]['create_time'] == '总计')) {
            $ad->num = count($data);
            $ad->fill($attr)->save();
        }

        return $ad;
    }
}

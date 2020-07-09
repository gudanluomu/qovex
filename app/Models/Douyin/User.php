<?php

namespace App\Models\Douyin;

use App\Scopes\RuleScope;
use App\Util\Douyin\UserContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class User extends Model implements UserContract
{
    protected $table = 'douyin_users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RuleScope());
    }

    public function getCookie(): string
    {
        return $this->cookie;
    }

    public function getNick(): string
    {
        return $this->nickname;
    }

    public function fillUserInfo(array $data)
    {
        $fillable = [
            'bind_phone',
            'uid',
            'short_id',
            'unique_id',
            'avatar_url' => 'avatar_thumb.url_list.0',
            'nickname',
            'sec_uid',
            'aweme_count',
            'following_count',
            'follower_count',
            'with_fusion_shop_entry',
            'with_commerce_entry',
            'bind_taobao_pub',
            'with_shop_entry',
        ];

        foreach ($fillable as $k => $v) {
            if (is_numeric($k))
                $k = $v;

            $this->{$k} = Arr::get($data, $v);
        }

        $this->info_update_time = date('Y-m-d H:i:s');
    }

    public function setPidAttribute($value)
    {
        if ($value) {
            $this->attributes['pid'] = $value;

            $pidArr = explode('_', $value);

            $this->member_id = $pidArr[1];
            $this->site_id = $pidArr[2];
            $this->adzone_id = $pidArr[3];

            $this->pid_update_time = date('Y-m-d H:i:s');
        }
    }

    public function isExpired()
    {
        return now()->timestamp > strtotime($this->cookie_expire_time);
    }
}

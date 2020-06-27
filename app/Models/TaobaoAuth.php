<?php

namespace App\Models;

use App\Scopes\RuleScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaobaoAuth extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'expire_time',
        'access_token',
        'token_type',
        'expires_in',
        'refresh_token',
        'refresh_token_valid_time',
        're_expires_in',
        'r1_expires_in',
        'r2_expires_in',
        'w1_expires_in',
        'w2_expires_in',
        'r1_valid',
        'r2_valid',
        'w1_valid',
        'w2_valid',
        'taobao_user_nick',
        'taobao_user_id',
        'sub_taobao_user_id',
        'sub_taobao_user_nick',
        'taobao_open_uid',
    ];

    public function getExpireTimeStrAttribute()
    {
        return Carbon::createFromTimestampMs($this->expire_time);
    }

    public function isExpired()
    {
        return now()->timestamp > ($this->expire_time / 1000);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RuleScope());
    }
}

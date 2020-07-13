<?php

namespace App\Observers\Douyin;

use App\Jobs\DouyinVideoGetPodcast;
use App\Models\Douyin\User;

class UserObserver
{

    public function created(User $user)
    {
        //获取视频
        dispatch(new DouyinVideoGetPodcast($user));
    }
}

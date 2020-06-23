<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->group_id = auth()->user()->group_id;
    }

    public function deleted(User $user)
    {
        //清除权限
        $user->roles()->detach();
    }

}

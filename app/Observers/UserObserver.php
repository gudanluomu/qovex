<?php

namespace App\Observers;

use App\User;

class UserObserver extends BaseObserver
{
    public function creating(User $user)
    {
        $this->groupId($user);
    }

    public function deleted(User $user)
    {
        //清除权限
        $user->roles()->detach();
    }

}

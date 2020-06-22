<?php

namespace App\Observers;

use App\User;

class UserObserver
{

    public function deleted(User $user)
    {
        //清除权限
        $user->roles()->detach();
    }

}

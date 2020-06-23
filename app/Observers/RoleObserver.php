<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    public function creating(Role $role)
    {
        $role->group_id = auth()->user()->group_id;
    }
}

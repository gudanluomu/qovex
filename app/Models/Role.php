<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    protected $perPage = 10;

    //已有权限id数组
    public function getPermissionIdsAttribute()
    {
        return $this->permissions->pluck('id')->toArray();
    }
}

<?php

namespace App\Models;

use App\Scopes\RuleScope;

class Role extends \Spatie\Permission\Models\Role
{
    protected $perPage = 10;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RuleScope());
    }

    //已有权限id数组
    public function getPermissionIdsAttribute()
    {
        return $this->permissions->pluck('id')->toArray();
    }
}

<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RuleScope implements Scope
{
    public $hasDepartment;
    public $hasUser;

    public function __construct($hasDepartment = false, $hasUser = false)
    {
        $this->hasDepartment = $hasDepartment;
        $this->hasUser = $hasUser;
    }

    public function apply(Builder $builder, Model $model)
    {
        $user = auth()->user();

        //超管或未登录跳过
        if (!$user || $user->isAdmin()) return;

        $builder->where('group_id', $user->group_id);

        //团长
        if ($user->isHead()) return;

        //有部门关联,并且是组长
        if ($this->hasDepartment && $user->isHead2())
            $builder->where('department_id', $user->department_id);
        //员工关联
        elseif ($this->hasUser)
            $builder->where('user_id', $user->id);
    }
}

<?php

namespace App;

use App\Models\Department;
use App\Models\Group;
use App\Scopes\RuleScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $perPage = 10;

    protected $fillable = [
        'name', 'email', 'password', 'department_id', 'department_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $departmentTypeArr = [
        1 => '员工',
        2 => '上级'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RuleScope());
    }

    //已有权限id数组
    public function getRoleIdsAttribute()
    {
        return $this->roles->pluck('id')->toArray();
    }

    //密码加密
    public function setPasswordAttribute($value)
    {
        if ($value)
            $this->attributes['password'] = Hash::make($value);
    }

    //部门关联
    public function department()
    {
        return $this->belongsTo(Department::class)->withDefault(['name' => '(暂无)']);
    }

    public function getDepartmentTypeDescAttribute()
    {
        return Arr::get($this->departmentTypeArr, $this->department_type, '未知');
    }

    //团队关联
    public function group()
    {
        return $this->belongsTo(Group::class)->withDefault();
    }

    //是否是团长
    public function isHead()
    {
        return auth()->id() == auth()->user()->group->user_id;
    }

    //是否是超管
    public function isAdmin()
    {
        return auth()->user()->email == '931692760@qq.com';
    }

    //组长
    public function isHead2()
    {
        return auth()->user()->department_type == 2;
    }
}

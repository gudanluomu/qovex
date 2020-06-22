<?php

namespace App;

use App\Models\Department;
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

    //部门关联
    public function getDepartmentTypeDescAttribute()
    {
        return Arr::get($this->departmentTypeArr, $this->department_type, '未知');
    }
}

<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $perPage = 10;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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
}

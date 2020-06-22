<?php

namespace App\Http\Requests;

class RoleRequest extends FormRequest
{
    public function rules()
    {
        $roles = [
            'name' => 'required|unique:roles,name',
        ];

        //编辑 唯一条件
        if ($this->method() === 'PUT')
            $roles['name'] .= ',' . $this->route('role')->id;


        return $roles;
    }
}

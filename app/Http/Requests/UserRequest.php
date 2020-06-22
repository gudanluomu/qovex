<?php

namespace App\Http\Requests;

class UserRequest extends FormRequest
{
    public function rules()
    {
        $roles = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'nullable|min:6|max:16',
        ];

        //编辑 唯一条件
        if ($this->method() === 'PUT')
            $roles['email'] .= ',' . $this->route('user')->id;

        return $roles;
    }
}

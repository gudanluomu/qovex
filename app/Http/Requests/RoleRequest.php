<?php

namespace App\Http\Requests;

class RoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'request'
        ];
    }
}

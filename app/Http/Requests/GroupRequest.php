<?php

namespace App\Http\Requests;

class GroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'desc' => 'max:200'
        ];
    }
}

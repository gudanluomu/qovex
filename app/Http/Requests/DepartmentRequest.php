<?php

namespace App\Http\Requests;


class DepartmentRequest extends FormRequest
{
    public function rules()
    {
        if ($this->method() === 'DELETE') {
            return [
                '*' => function ($attribute, $value, $fail) {

                    $department = $this->route('department');

                    if ($department->children()->count() > 0)
                        return $fail('有下属部门,不可删除');

                    if ($department->users()->count() > 0)
                        return $fail('部门下有员工,不可删除');
                },
            ];
        }


        return [
            'name' => 'required',
        ];
    }
}

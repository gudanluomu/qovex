<?php

namespace App\Http\Requests;


use App\Models\Douyin\User;
use App\Util\Douyin\GetDouplusRefund;
use App\Util\Douyin\Request;

class DouplusRequest extends FormRequest
{
    public function rules()
    {
        return [
            'pay_user_id' => [function ($attribute, $value, $fail) {

                $user = User::query()->findOrFail($value);

                $this->offsetSet('pay_user', $user);

                $res = (new Request())->request(new GetDouplusRefund(), $user);

                $pay_amount = $this->budget * $this->num;

                if ($pay_amount > $res['total_balance']) {
                    $fail('付款账号余额不足');
                }
            }],
            'package_name' => 'required_if:save_package,1|max:16',
            'package_desc' => 'required_if:save_package,1|max:200'
        ];
    }

    public function messages()
    {
        return [
            'package_name.required_if' => '定向包名称必须填写',
            'package_name.max' => '定向包名称过长',
            'package_desc.required_if' => '定向包描述必须填写',
            'package_desc.max' => '定向包描过长',
        ];
    }
}

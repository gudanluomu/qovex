<?php


namespace App\Util\Douyin\Api;

/**
 * 修改用户信息
 * @package App\Util\Douyin\Api
 */
class CommitUser extends BaseApi
{
    public $url = 'https://api3-normal-c-lf.amemv.com/aweme/v1/commit/user/';

    public $risk = true;

    public $form_params = [
        'is_vcd' => 1,
        'page_from' => 1,
    ];

    public function getMethod()
    {
        return 'POST';
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setFormParams($key, $value)
    {
        $this->form_params[$key] = $value;
        return $this;
    }

    public function getOptions()
    {
        $this->setFormParams('uid', $this->user->getUid());

        return array_merge(parent::getOptions(), [
            'form_params' => $this->form_params
        ]);
    }

}

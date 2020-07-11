<?php


namespace App\Util\Douyin;


use App\Models\Douyin\Video;
use Illuminate\Support\Arr;

class VideoUpdateRequest extends WebRequest
{
    public $form_params;

    public function url(): string
    {
        return 'https://creator.douyin.com/web/api/media/aweme/update/';
    }

    public function method(): string
    {
        return 'post';
    }

    public function options(): array
    {
        return [
            'query' => $this->comQuery(),
            'form_params' => $this->form_params,
            'headers' => [
                'x-csrf-token' => "123123",
            ],
        ];
    }

    public function setFormParams($form_params)
    {
        $this->form_params = $form_params;
    }

    public function getCookie(UserContract $user)
    {
        return rtrim($user->getCookie(), ';') . ";csrf_token=123123;";
    }


}

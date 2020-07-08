<?php


namespace App\Util\Douyin;


interface UserContract
{
    public function getCookie(): string;

    public function fillUserInfo(array $data);
}

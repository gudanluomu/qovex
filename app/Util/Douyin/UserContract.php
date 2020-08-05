<?php


namespace App\Util\Douyin;


interface UserContract
{
    public function getCookie();

    public function getNick(): string;

    public function fillUserInfo(array $data);

    public function getUid();
}

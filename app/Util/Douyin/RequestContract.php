<?php


namespace App\Util\Douyin;


interface RequestContract
{
    //公共请求参数
    public function comQuery(): array;

    public function method(): string;

    public function url(): string;

    public function options(): array;

    public function verifyResponse($res);

    public function isRisk(): bool;

    public function getCookie(UserContract $user);
}

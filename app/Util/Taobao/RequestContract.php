<?php


namespace App\Util\Taobao;


interface RequestContract
{
    public function getApiMethodName(): string;

    public function getApiFormParams(): array;
}

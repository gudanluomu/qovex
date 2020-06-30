<?php


namespace App\Util\Taobao;


class OrderGetRequest implements RequestContract
{
    public function getApiMethodName(): string
    {
        return 'taobao.tbk.sc.order.details.get';
    }

    public function getApiFormParams(): array
    {
        return [
            'end_time' => now()->toDateTimeString(),
            'start_time' => now()->addMinutes(10)->toDateTimeString(),
        ];
    }
}

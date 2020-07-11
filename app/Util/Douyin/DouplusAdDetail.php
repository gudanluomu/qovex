<?php


namespace App\Util\Douyin;


class DouplusAdDetail extends AppRequest
{
    public $task_id;

    public function setTaskId($task_id)
    {
        $this->task_id = $task_id;
        return $this;
    }

    public function url(): string
    {
        return 'https://aweme.snssdk.com/aweme/v2/douplus/ad/';
    }

    public function options(): array
    {
        return [
            'query' => array_merge($this->comQuery(), ['task_id' => $this->task_id]),
            'headers' => [
                'User-Agent' => 'com.ss.android.ugc.aweme/570 (Linux; U; Android 8.1.0; zh_CN; Redmi 6A; Build/O11019; Cronet/58.0.2991.0)',
            ]
        ];
    }

    public function isRisk(): bool
    {
        return true;
    }
}

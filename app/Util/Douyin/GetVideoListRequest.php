<?php


namespace App\Util\Douyin;


use App\Models\Douyin\Video;
use Illuminate\Support\Arr;

class GetVideoListRequest extends WebRequest
{
    public $query;
    public $video;

    public function __construct()
    {
        $this->setParams();
    }

    public function url(): string
    {
        return 'https://creator.douyin.com/web/api/media/aweme/post/';
    }

    public function options(): array
    {
        return [
            'query' => $this->query,
            'headers' => [
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36'
            ]
        ];
    }

    public function setParams($max_cursor = 0, $count = 10, $min_cursor = 0, $status = 1)
    {
        $this->query = array_merge($this->comQuery(), [
            'scene' => 'mix',
            'status' => $status,
            'count' => $count,
            'min_cursor' => $min_cursor,
            'max_cursor' => $max_cursor,
        ]);

        return $this;
    }

    public function setVideo(Video $video)
    {
        $this->video = $video;

        $max_cursor = ($video->create_time + 1) . '000';
        $min_cursor = ($video->create_time - 1) . '000';

        $this->setParams($max_cursor, 1, $min_cursor);
    }

    public function verifyResponse($res)
    {
        if (!$this->video) {
            return parent::verifyResponse($res);
        }

        $newVideo = collect(Arr::get($res, 'aweme_list'))->where('aweme_id', $this->video->aweme_id)->first();

        if ($newVideo) {
            return $newVideo;
        }

        return false;
    }

}

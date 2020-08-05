<?php

namespace App\Jobs;

use App\Models\Douyin\User;
use App\Models\Douyin\VideoAd;
use App\Util\Douyin\Api\DouplusOrderItemList;
use App\Util\Douyin\Api\DouplusOrderStatByItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class DouyinItemAdGetPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $itemListApi = new DouplusOrderItemList();
        $statApi = new DouplusOrderStatByItem();

        //视频列表
        $res = $itemListApi->setUser($this->user)->request()->getContents();
        //视频id
        $item_ids = Arr::pluck($res['item_info'] ?: [], 'item_id');

        if ($item_ids) {
            //并发获取视频消耗
            $statApi->setUser($this->user)
                ->setItemIds($item_ids)
                ->allRequest(function (ResponseInterface $response, $item_id) {
                    //总计
                    $data = json_decode($response->getBody()->getContents(), 1)['order_data'];
                    VideoAd::createByApi($data, $item_id, $this->user);
                });
        }
    }
}

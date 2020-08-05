<?php

namespace App\Console\Commands;

use App\Jobs\DouyinItemAdGetPodcast;
use App\Models\Douyin\User;
use Illuminate\Console\Command;

class GetDouyinItemAdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'douyin:item-ad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抖音投放视频列表';


    public function handle()
    {
        User::query()
            ->where('cookie_status', true)
            ->get()
            ->each(function ($user) {
                dispatch(new DouyinItemAdGetPodcast($user));
            });
    }
}

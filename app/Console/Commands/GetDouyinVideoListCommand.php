<?php

namespace App\Console\Commands;

use App\Jobs\DouyinVideoGetPodcast;
use App\Models\Douyin\User;
use Illuminate\Console\Command;

class GetDouyinVideoListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'douyin:video-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抖音视频列表更新';


    public function handle()
    {
        User::query()
            ->where('cookie_status', true)
            ->get()
            ->each(function ($user) {
                dispatch(new DouyinVideoGetPodcast($user));
            });
    }
}

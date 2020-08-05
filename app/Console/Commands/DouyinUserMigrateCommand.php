<?php

namespace App\Console\Commands;

use App\Models\Douyin\User;
use App\Util\Douyin\GetUserInfoRequest;
use App\Util\Douyin\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DouyinUserMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'douyin:user-migrate';

    public function handle()
    {

        $users = DB::connection('mysql2')->table('accounts')->get(['cookie']);

        $request = new Request();

        $userinfo = new GetUserInfoRequest();

        foreach ($users as $v) {
            try {
                $user = new User();
                $user->cookie = $this->getCookie($v);
                $user->cookie_status = true;
                $user->cookie_expire_time = date('Y-8-d H:i:s');
                $user->group_id = 1;
                $user->fillUserInfo($request->request($userinfo, $user));
                $user->save();

            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }
    }

    public function getCookie($v)
    {
        foreach (json_decode($v->cookie, 1) as $v) {
            if ($v['name'] == 'sessionid') {
                return 'sessionid=' . $v['value'];
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Spatie\Permission\Models\Permission;
use Illuminate\Console\Command;

class PermissionCreateCommand extends Command
{
    protected $signature = 'permission:create';

    protected $description = '创建权限';

    public function handle()
    {
        //读取数据
        $data = config('data.permission');

        foreach ($data as $perm) {
            //更新或创建
            Permission::query()->updateOrCreate(['name' => $perm['name']], $perm);
        }
    }
}

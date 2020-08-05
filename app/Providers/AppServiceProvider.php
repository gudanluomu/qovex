<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Auth::provider(\App\Auth\EloquentUserProvider::class, function ($app, array $config) {
            return new \App\Auth\EloquentUserProvider($app['hash'], $config['model']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Role::observe(\App\Observers\RoleObserver::class);
        \App\Models\Department::observe(\App\Observers\DepartmentObserver::class);
        \App\Models\Douyin\Video::observe(\App\Observers\Douyin\VideoObserver::class);
        \App\Models\Douyin\User::observe(\App\Observers\Douyin\UserObserver::class);
        \App\Models\Douyin\VideoAd::observe(\App\Observers\Douyin\VideoAdObserver::class);

        View::composer('layouts.sidebar', function ($view) {

            $siderbar_menus = config('data.sidebarmenu');
            //去除admin菜单
            if (!auth()->user()->isAdmin()) {
                $siderbar_menus = collect($siderbar_menus)->where('admin', '!=', 1)->all();
            }

            $view->with([
                'siderbar_perms' => collect(config('data.permission', []))->pluck('name')->all(),
                'siderbar_menus' => $siderbar_menus,
            ]);
        });
    }
}

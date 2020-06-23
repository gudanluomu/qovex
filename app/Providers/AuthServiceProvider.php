<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            //admin专属路由
            $adminPermis = collect(config('data.sidebarmenu', []))
                ->where('admin', 1)
                ->pluck('route')
                ->all();

            return ($user->isHead() && !in_array($ability, $adminPermis)) || $user->isAdmin() ? true : null;
        });
    }
}

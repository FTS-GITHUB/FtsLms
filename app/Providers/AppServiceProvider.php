<?php

namespace App\Providers;

use App\Enums\Permissions\RoleTypeEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // bypassing the roles/permissions check
        Gate::before(function ($user, $ability) {
            return $user->hasRole(RoleTypeEnum::SUPER_ADMIN) ? true : null;
        });
    }
}

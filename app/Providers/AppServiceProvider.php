<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('apiUser', session('api_user'));
            $view->with('apiNotifications', session('api_notifications', []));
            $view->with('apiPermissions', session('api_user.permissions', []));
        });
    }
}

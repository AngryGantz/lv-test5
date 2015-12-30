<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booted(function($app1)
        {
            // Replace SleepingOwl AdminAuthManager on usual AuthManager
            $app1->offsetUnset('admin.auth');
            $app1->singleton('admin.auth', function($app2)
            {
                return $app2['auth'];
            });
        });
    }
}

<?php

namespace App\Providers;

use App\Utils\UserEncrypt;
use App\Utils\UserToken;
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
        $this->app->bind('UserEncrypt', function() {
            return new UserEncrypt();
        });
        $this->app->bind('UserToken', function() {
            return new UserToken();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

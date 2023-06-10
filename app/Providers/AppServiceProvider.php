<?php

namespace App\Providers;

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
       // $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');
       // if($this->app->environment('production')) {
         //   URL::forceScheme('https');
       // }
        //if (env('APP_FORCE_HTTPS', false)) {
          //  URL::forceScheme('https');
        //}
    }
}

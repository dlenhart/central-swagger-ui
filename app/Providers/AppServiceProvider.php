<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Use this to force https
        
        //$this->app['request']->server->set('HTTPS', true);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Use this to force https

        // URL::forceRootUrl( config( 'app.url' ) );

        // if ( app()->environment() != 'local' ) {
        //     URL::forceScheme( 'https' );
        // }
    }
}

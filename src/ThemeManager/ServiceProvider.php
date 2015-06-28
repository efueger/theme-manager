<?php

namespace ThemeManager;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as ServiceProviderSupport;

class ServiceProvider extends ServiceProviderSupport
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/theme-manager.php' => config_path( 'theme-manager.php' ),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( 'theme.manager', function () {
            return theme_manager( Config::get( 'theme-manager.base_path', null ) );
        } );
    }
}

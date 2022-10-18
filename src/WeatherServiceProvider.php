<?php
namespace Mihai\Weather;

use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'weather');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([__DIR__.'/config/globals.php'=>config_path('globals.php')]);
    }

    public function register()
    {

    }
}
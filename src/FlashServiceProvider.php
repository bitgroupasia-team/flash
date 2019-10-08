<?php

namespace Bitgroupasia\Flash;

use Bitgroupasia\Flash\Flash;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred
     *
     * @var bool
     */
    protected $defer = false;

     /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Bitgroupasia\Flash\SessionStore',
            'Bitgroupasia\Flash\LaravelSessionStore'
        );
        $this->app->singleton('flash', function () {
            return $this->app->make('Bitgroupasia\Flash\FlashNotifier');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'flash');

        $this->publishes([
            __DIR__ . '/views' =>  base_path('resources/views/vendor/flash')
        ]);
    }

}

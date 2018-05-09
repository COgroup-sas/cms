<?php

namespace Cogroup\Cms;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/cogroupcms'),
        ]);
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/cogroup/cms'),
        ], 'public');
    }

    /**
     * Register the COgroup CMS routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'prefix' => config('cogroupcms.uri', 'cms'),
            'namespace' => 'Cogroup\Cms\Http\Controllers',
            'middleware' => ['admin', 'auth'],
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Register the Horizon resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cogroupcms');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('HORIZON_PATH')) {
            define('HORIZON_PATH', realpath(__DIR__.'/../'));
        }

        $this->configure();
        $this->offerPublishing();
        $this->registerServices();
        $this->registerCommands();
        $this->registerQueueConnectors();
    }

    /**
     * Setup the configuration for Horizon.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/cogroupcms.php', 'cogroupcms'
        );
    }

    /**
     * Setup the resource publishing groups for Horizon.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/cogroupcms.php' => config_path('cogroupcms.php'),
            ], 'cogroupcms-config');
        }
    }
}

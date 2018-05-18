<?php

namespace Cogroup\Cms;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerResources();
        $this->registerMigrations();
        $this->registerTranslations();
        $this->defineAssetPublishing();
        $this->registerViewComposer();
        $this->registerValidationRules();
    }

    /**
     * Register the COgroup CMS routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
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
     * Register the Horizon resources.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the Horizon resources.
     *
     * @return void
     */
    protected function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('COGROUPCMS_PATH')) {
            define('COGROUPCMS_PATH', realpath(__DIR__.'/../'));
        }

        $this->configure();
        $this->offerPublishing();
        /*$this->registerCommands();
        $this->registerQueueConnectors();*/
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('admin', Http\Middleware\AdminMiddleware::class);
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

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/cogroup/cms'),
        ], 'cogroupcms-assets');

        $this->publishes([
            __DIR__.'/../public/fonts' => public_path('fonts'),
        ], 'cogroupcms-assets');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function registerViewComposer()
    {
        View::composer(
          '*', 'Cogroup\Cms\Http\ViewComposers\CmsComposer'
        );
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function registerValidationRules()
    {
        Validator::extend('phone', function($attribute, $value, $parameters) {
            return is_string($value) && preg_match("/\(\d{2}\)[ ]\d{1}[ ]\d{3}-\d{4}/", $value);
        });

        Validator::extend('mobilephone', function($attribute, $value, $parameters) {
            if(!empty($value)) return is_string($value) && preg_match("/\(\d{2}\)[ ]\d{3}-\d{3}-\d{4}/", $value);
            else return true;
        });

        Validator::replacer('mobilephone', function ($message, $attribute, $rule, $parameters) {
            return trans("validation.custom.mobilephone");
        });
    }
}

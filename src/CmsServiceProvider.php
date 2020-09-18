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
        $this->registerResources();
        $this->registerMigrations();
        $this->registerTranslations();
        $this->defineAssetPublishing();
        $this->defineFontPublishing();
        $this->defineErrorViewsPublishing();
        $this->defineMigrationsPublishing();
        $this->defineSeedersPublishing();
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
     * Register the COgroup CMS resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cogroupcms');
    }

    /**
     * Register the COgroup CMS migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the COgroup CMS translations.
     *
     * @return void
     */
    protected function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/'),
        ], 'cogroupcms-translations');
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
        $this->registerCommands();
        $this->registerHelper();
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', Http\Middleware\AdminMiddleware::class);
        $this->registerRoutes();
    }

    /**
     * Register helper file
     *
     * @return void
     */
    protected function registerHelper()
    {
        require_once __DIR__.'/CmsHelper.php';
    }

    /**
     * Setup the configuration for COgroup CMS.
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
     * Define the asset publishing config.
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
     * Define the asset publishing assets.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/cogroup/cms'),
        ], 'cogroupcms-assets');
    }

    /**
     * Define the asset publishing fonts.
     *
     * @return void
     */
    public function defineFontPublishing()
    {
        $this->publishes([
            __DIR__.'/../public/fonts' => public_path('fonts'),
        ], 'cogroupcms-fonts');
    }

    /**
     * Define the asset publishing custom error views.
     *
     * @return void
     */
    public function defineErrorViewsPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views/errors' => base_path('resources/views/errors'),
            ], 'cogroupcms-errorviews');
        }
    }

    /**
     * Define the asset publishing migrations.
     *
     * @return void
     */
    public function defineMigrationsPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => base_path('database/migrations'),
            ], 'cogroupcms-migrations');
        }
    }

    /**
     * Define the asset publishing migrations.
     *
     * @return void
     */
    public function defineSeedersPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/seeders' => base_path('database/seeders'),
            ], 'cogroupcms-seeders');
        }
    }

    /**
     * Define the viewcomposer configuration.
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
     * Define the custom validation rules.
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

    /**
     * Register the COgroup CMS Artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\AssetsCommand::class,
                Console\ConfigCommand::class,
                Console\FontsCommand::class,
                Console\PublicErrorViewsCommand::class,
                Console\TranslationsCommand::class,
                Console\MigrationsCommand::class,
                Console\SeedersCommand::class,
            ]);
        }
    }
}

<?php

namespace Cogroup\Cms;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\ConsoleOutput;

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
        $this->registerSeeders();
        $this->registerTranslations();
        $this->defineAssetPublishing();
        $this->defineFontPublishing();
        $this->defineErrorViewsPublishing();
        $this->defineMailViewsPublishing();
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
        Route::group($this->routeConfiguration("web"), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
        Route::group($this->routeConfiguration("api"), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

    /**
     * Get the Telescope route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration($type = "web")
    {
        if($type == "web") :
            return [
                'namespace' => 'Cogroup\Cms\Http\Controllers',
                'middleware' => 'web',
            ];
        elseif($type == "api") :
            return [
                'namespace' => 'Cogroup\Cms\Http\Controllers',
                'domain' => config('cogroupcms.domain', NULL),
                'prefix' => config('cogroupcms.apiprefix', 'api'),
                'middleware' => ['api']
            ];
        endif;
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
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
        
    }

    /**
     * Register the COgroup CMS seeders.
     *
     * @return void
     */
    protected function registerSeeders()
    {
        if ($this->app->runningInConsole()) {
            if ($this->isConsoleCommandContains([ 'db:seed', '--seed' ], [ '--class', 'help', '-h' ])) {
                $this->addSeedsAfterConsoleCommandFinished();
            }
        }
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
        //$router->aliasMiddleware('cogroupcmsapi', Http\Middleware\CogroupcmsapiMiddleware::class);
        $router->aliasMiddleware('cogroupcmsregister', Http\Middleware\CogroupcmsregisterMiddleware::class);
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
     * Define the asset publishing custom error views.
     *
     * @return void
     */
    public function defineMailViewsPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views/vendor' => base_path('resources/views/vendor'),
            ], 'cogroupcms-mailviews');
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
                Console\PublicMailViewsCommand::class,
                Console\TranslationsCommand::class,
                Console\MigrationsCommand::class,
                Console\SeedersCommand::class,
            ]);
        }
    }

    /**
     * Get a value that indicates whether the current command in console
     * contains a string in the specified $fields.
     *
     * @param string|array $contain_options
     * @param string|array $exclude_options
     *
     * @return bool
     */
    protected function isConsoleCommandContains($contain_options, $exclude_options = null) : bool
    {
        $args = Request::server('argv', null);
        if (is_array($args)) {
            $command = implode(' ', $args);
            if (
                Str::contains($command, $contain_options) &&
                ($exclude_options == null || !Str::contains($command, $exclude_options))
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Add seeds from the $seed_path after the current command in console finished.
     */
    protected function addSeedsAfterConsoleCommandFinished()
    {
        Event::listen(CommandFinished::class, function(CommandFinished $event) {
            // Accept command in console only,
            // exclude all commands from Artisan::call() method.
            if ($event->output instanceof ConsoleOutput) {
                $this->addSeedsFrom(__DIR__.'/../database/seeders');
            }
        });
    }

    /**
     * Register seeds.
     *
     * @param string  $seeds_path
     * @return void
     */
    protected function addSeedsFrom($seeds_path)
    {
        $file_names = glob( $seeds_path . '/*.php');
        foreach ($file_names as $filename)
        {
            $classes = $this->getClassesFromFile($filename);
            foreach ($classes as $class) {
                echo "\033[1;33mSeeding:\033[0m {$class}\n";
                $startTime = microtime(true);
                Artisan::call('db:seed', [ '--class' => $class, '--force' => '' ]);
                $runTime = round(microtime(true) - $startTime, 2);
                echo "\033[0;32mSeeded:\033[0m {$class} ({$runTime} seconds)\n";
            }
        }
    }

    /**
     * Get full class names declared in the specified file.
     *
     * @param string $filename
     * @return array an array of class names.
     */
    private function getClassesFromFile(string $filename) : array
    {
        // Get namespace of class (if vary)
        $namespace = "";
        $lines = file($filename);
        $namespaceLines = preg_grep('/^namespace /', $lines);
        if (is_array($namespaceLines)) {
            $namespaceLine = array_shift($namespaceLines);
            $match = array();
            preg_match('/^namespace (.*);$/', $namespaceLine, $match);
            $namespace = array_pop($match);
        }

        // Get name of all class has in the file.
        $classes = array();
        $php_code = file_get_contents($filename);
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $class_name = $tokens[$i][1];
                if ($namespace !== "") {
                    $classes[] = $namespace . "\\$class_name";
                } else {
                    $classes[] = $class_name;
                }
            }
        }

        return $classes;
    }
}

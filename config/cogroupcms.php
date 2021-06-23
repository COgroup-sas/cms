<?php

return [

    /*
    |--------------------------------------------------------------------------
    | COgroup CMS Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix will be used for cms route.
    |
    */

    'prefix' => env('COGROUPCMS_PREFIX', 'cogroupcms:'),

    /*
    |--------------------------------------------------------------------------
    | COgroup CMS color theme
    |--------------------------------------------------------------------------
    |
    | This prefix will be used for set default theme in all cms sections.
    |
    */

    'color_theme' => env('COGROUPCMS_COLORTHEME', 'blue'),

    /*
    |--------------------------------------------------------------------------
    | COgroup CMS url
    |--------------------------------------------------------------------------
    |
    | This prefix will be used for set default uri from CMS access.
    |
    */

    'uri' => env('COGROUPCMS_URI', 'cms'),

    /*
    |--------------------------------------------------------------------------
    | COgroup CMS background login
    |--------------------------------------------------------------------------
    |
    | This prefix will be used for set default uri background from CMS access.
    |
    */

    'bguri' => env('COGROUPCMS_BGURI', 'vendor/cogroup/cms/images/bg.jpg'),

    /*
    |--------------------------------------------------------------------------
    | COgroup CMS Dashboard class
    |--------------------------------------------------------------------------
    |
    | This variable set the class call for dashboard. When is empty, the COgroupCMS call default function
    | 
    | The class name must include the namespace:
    | example: \App\Http\Controllers\MyDashboardController
    |
    | The main function is index by default
    |
    */

    'dashboard' => '',

    /*
    |--------------------------------------------------------------------------
    | COgroup Notifications
    |--------------------------------------------------------------------------
    |
    | This variable set type notifications system
    |
    */

    'via' => ['mail', 'database'],

    /*
    |--------------------------------------------------------------------------
    | COgroup Filesystem Default save
    |--------------------------------------------------------------------------
    |
    | This variable set filesystem is save
    |
    */

    'filesystem' => env('COGROUPCMS__FILESYSTEM', 'filesystems.default'),

    /*
    |--------------------------------------------------------------------------
    | COgroup api domain
    |--------------------------------------------------------------------------
    |
    | This variable set api domain
    |
    */

    'domain' => env('COGROUPCMS_APIDOMAIN', NULL),

    /*
    |--------------------------------------------------------------------------
    | COgroup api prefix
    |--------------------------------------------------------------------------
    |
    | This variable set api prefix
    |
    */

    'apiprefix' => env('COGROUPCMS_APIPREFIX', 'api'),

    /*
    |--------------------------------------------------------------------------
    | COgroup api front url
    |--------------------------------------------------------------------------
    |
    | This variable set url to front where use api routes
    |
    */

    'apiurl' => env('COGROUPCMS_APIFRONTURL', env('APP_URL')),

];

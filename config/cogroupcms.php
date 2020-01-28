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

    'color_theme' => env('COGROUPCMS_COLORTHEME', 'orange'),

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

];

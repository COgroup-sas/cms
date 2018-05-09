<?php

return [

    /*
    |--------------------------------------------------------------------------
    | COgroup CMS Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix will be used when storing all Horizon data in Redis. You
    | may modify the prefix when you are running multiple installations
    | of Horizon on the same server so that they don't have problems.
    |
    */

    'prefix' => env('COGROUPCMS_PREFIX', 'cogroupcms:'),

    /*
    |--------------------------------------------------------------------------
    | COgroup CMS color theme
    |--------------------------------------------------------------------------
    |
    | This prefix will be used when storing all Horizon data in Redis. You
    | may modify the prefix when you are running multiple installations
    | of Horizon on the same server so that they don't have problems.
    |
    */

    'color_theme' => env('COGROUPCMS_COLORTHEME', 'light-blue-skin'),

];

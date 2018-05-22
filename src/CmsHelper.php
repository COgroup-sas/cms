<?php

use Cogroup\Cms\Http\Controllers\CmsController;
use Illuminate\Support\Facades\Auth;

if (! function_exists('cms_roles_check')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return mixed|\Illuminate\Foundation\Application
     */
    function cms_roles_check($check, $moduleslug, $type = 'view')
    {
        return CmsController::checkPermission($check, $moduleslug, $type);
    }
}

if (! function_exists('cms_get_modules')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return mixed|\Illuminate\Foundation\Application
     */
    function cms_get_modules($modulename = NULL, $inmenu = 'Y', $idrol = NULL)
    {
        return CmsController::getModules($modulename, $inmenu, $idrol);
    }
}

if (! function_exists('cms_settings')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return mixed|\Illuminate\Foundation\Application
     */
    function cms_settings()
    {
        $cms = new CmsController();
        return $cms->defaultsettings;
    }
}
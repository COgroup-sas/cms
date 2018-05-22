<?php

use Cogroup\Cms\Http\Controllers\CmsController;

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
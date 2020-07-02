<?php

use Cogroup\Cms\Http\Controllers\CmsController;
use Cogroup\Cms\Models\Files;
use Cogroup\Cms\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('cms_version')) {
    /**
     * Return CMS version
     */
    function cms_version()
    {
        return "CMS V1.8.12";
    }
}

if (! function_exists('cms_roles_check')) {
    /**
     * Check a permission into rol
     *
     * @param  User     $check || integer $chek
     * @param  string   $moduleslug
     * @param  string   $type
     * @return mixed|\Cogroup\Cms\CmsController
     */
    function cms_roles_check($check, $moduleslug, $type = 'view')
    {
        return CmsController::checkPermission($check, $moduleslug, $type);
    }
}

if (! function_exists('cms_get_modules')) {
    /**
     * Get cms modules
     *
     * @param  string       $modulename || integer $modulename
     * @param  enum(Y,N)    $inmenu
     * @param  integer      $idrol
     * @return mixed|\Cogroup\Cms\CmsController
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
     * @param  void
     * @return mixed|\Cogroup\Cms\CmsController
     */
    function cms_settings()
    {
        $cms = new CmsController();
        return $cms->defaultsettings;
    }
}

if (! function_exists('cms_print_submenu')) {
    /**
     * Get the available container instance.
     *
     * @param  object   $submenu
     * @param  string   $route
     * @return mixed|\Cogroup\Cms\CmsController
     */
    function cms_print_submenu($submenu, $route)
    {
        return CmsController::printSubmenu($submenu, $route);
    }
}

if (! function_exists('cms_format_date')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $date
     * @return mixed|\Carbon
     */
    function cms_format_date($date)
    {
        if(!is_null($date) and !empty($date)) return \Carbon\Carbon::createFromFormat("Y-m-d", $date)->format(cms_settings()->dateformat);
        else return '';
    }
}

if (! function_exists('cms_format_time')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $time
     * @return mixed|\Carbon
     */
    function cms_format_time($time)
    {
        if(!is_null($time) and !empty($time)) return \Carbon\Carbon::createFromFormat("H:i:s", $time)->format(cms_settings()->timeformat);
        else return '';
    }
}

if (! function_exists('cms_format_datetime')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $datetime
     * @return mixed|\Carbon
     */
    function cms_format_datetime($datetime)
    {
        if(!is_null($datetime) and !empty($datetime)) :
            return \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $datetime)->format(cms_settings()->dateformat." ".cms_settings()->timeformat);
        else :
            return '';
        endif;
    }
}

if (! function_exists('cms_get_file_attribute')) {
    /**
     * Get the available container instance.
     *
     * @param  integer  $id
     * @param  string   $attribute
     * @return mixed|\Cogroup\Cms\Models\Files
     */
    function cms_get_file_attribute($id, $attribute)
    {
        $file = Files::where('id', $id)->first();
        return $file->{$attribute};
    }
}

if (! function_exists('cms_get_total_unread_notifications')) {
    /**
     * Get the available container instance.
     *
     * @param  integer  $id
     * @param  string   $attribute
     * @return mixed|\Cogroup\Cms\Models\Files
     */
    function cms_get_total_unread_notifications()
    {
        $user = User::find(auth()->user()->id);
        return $user->unreadNotifications()->count();
    }
}
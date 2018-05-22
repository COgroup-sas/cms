<?php

namespace Cogroup\Cms\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    const DELIMITER = '|';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $module
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {
        if (auth()->check()) :
            if (!is_array($module)) :
                $module = explode(self::DELIMITER, $module);
            endif;
            if(!isset($module[1])) :
                $module[1] = "view";
            endif;
            if(strstr($module[1], ":")) :
                $module[1] = explode(':', $module[1]);
                if(count($module[1]) > 1) :
                    $module[2] = $module[1][1];
                    $module[1] = $module[1][0];
                endif;
            endif;
            if(isset($module[2])) :
                if (cms_roles_check(Auth::user(), $module[0], $module[1]) == true or cms_roles_check(Auth::user(), $module[0], $module[2]) == true) :
                    return $next($request);
                else :
                    abort(403, 'Unauthorized action.');
                endif;
            else :
                if (cms_roles_check(Auth::user(), $module[0], $module[1]) == false) :
                    abort(403, 'Unauthorized action.');
                endif;
            endif;
        endif;

        return $next($request);
    }
}
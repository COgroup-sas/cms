<?php

namespace Cogroup\Cms\Http\Middleware;

class CogroupcmsregisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $module
     * @return mixed
     */
    public function handle($request, $next)
    {
        return cms_settings()->enableregisteruser == "1" ? $next($request) : abort(404);
    }
}
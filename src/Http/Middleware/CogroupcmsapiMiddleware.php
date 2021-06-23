<?php

namespace Cogroup\Cms\Http\Middleware;

class CogroupcmsapiMiddleware
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
        return $request->wantsJson() ? $next($request) : abort(403);
    }
}
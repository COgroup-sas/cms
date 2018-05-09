<?php

namespace Cogroup\Cms\Http\Middleware;

use Closure;
use Cogroup\Cms\Models\Roles\RolesAccess;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) :
            $user = auth()->user();
            $access = RolesAccess::where('roles_id', $user->roles_id)
                                 ->where('view', '1')
                                 ->count();
            if($access == 0) :
                return redirect()->route('home');
            endif;
        endif;

        return $next($request);
    }
}

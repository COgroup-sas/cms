<?php
namespace Cogroup\Cms\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CmsComposer {
  /**
   * Bind data to the view.
   *
   * @param  View $view
   * @return void
   */
  public function compose(View $view) {
    $view->with('user', Auth::user());

    if(Auth::check()) :
      $modules = cms_get_modules();
    else :
      $modules = array();
    endif;

    $view->with('modules', $modules);

    
    if(!is_null(request()->route())) :
      $tmp = explode("/", request()->route()->getPrefix());
      if(count($tmp) > 1) $prefix = $tmp[1];
      else $prefix = '';
      $route = request()->route()->uri();
      $view->with('prefix', $prefix);
      $view->with('route', $route);
    else :
      $tmp = NULL;
    endif;
  }
}
<?php
namespace Cogroup\Cms\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cogroup\Cms\Models\Settings;
use Cogroup\Cms\Http\Controllers\CmsController;

class CmsComposer {
  /**
   * Bind data to the view.
   *
   * @param  View $view
   * @return void
   */
  public function compose(View $view) {
    $view->with('user', Auth::user());

    $cms = new CmsController();

    if(Auth::check()) :
      $modules = $cms->getModules();
    else :
      $modules = array();
    endif;

    $view->with('modules', $modules);

    $tmp = explode("/", request()->route()->getPrefix());
    if(count($tmp) > 1) $prefix = $tmp[1];
    else $prefix = '';
    $route = request()->route()->uri();

    $view->with('prefix', $prefix);
    $view->with('route', $route);
    $view->with('settings', $cms->defaultsettings);
  }
}
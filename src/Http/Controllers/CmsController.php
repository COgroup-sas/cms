<?php

namespace Cogroup\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Cogroup\Cms\Models\Modules;
use Cogroup\Cms\Models\Roles\Roles;
use Cogroup\Cms\Models\Roles\RolesAccess;
use App\Http\Controllers\Controller;

class CmsController extends Controller
{
  /**
  * Vars important
  */

  public $defaultsettings;
  public static $settings;
  public $scripts = array();
  public $csss = array();
  protected $request;
  public $modules, $prefix, $route;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest');
    self::setDefaultSettings();
    self::$settings = self::setDefaultSettings();
  }

  protected function setDefaultSettings() {
    $tmp = DB::table('settings')->get();
    if(!empty($tmp)) :
      $this->defaultsettings = new \stdClass();
      foreach ($tmp as $value) :
        $this->defaultsettings->{$value->setting} = $value->defaultvalue;
      endforeach;
    endif;
    //$this->defaultsettings->social = Social::whereNull('clients_id')->get();
  }

  public function registerScripts($script) {
    $this->scripts[] = $script;
    return true;
  }

  public function registerCss($css, $media = 'all') {
    $this->csss[] = array($css, $media);
    return true;
  }

  public static function getModules($modulename = NULL, $inmenu = 'Y', $idrol = NULL) {
    if(is_null($idrol)) :
      $idrol = Auth::user()->roles_id;
    endif;
    if(!is_numeric($modulename) and !is_null($modulename) and !empty($modulename)) :
      $tmp = Modules::select('id')->where('modulename', $modulename)->first();
      $id = $tmp->id;
    else :
      $id = (is_null($modulename)) ? 0 : $modulename;
    endif;
    if(!is_array($inmenu)) :
      $inmenu = explode(",", $inmenu);
    endif;
    $modules = Modules::select('modules.*', 'roles_access.roles_id', 'modules_id', 'view', 'create', 'update', 'delete')
                      ->join('roles_access', 'roles_access.modules_id', '=', 'modules.id')
                      ->where('modules.active', 'Y')
                      ->where('roles_access.roles_id', $idrol)
                      ->where('parent', $id)
                      ->whereIn('inmenu', $inmenu)
                      ->orderBy('order', 'asc')
                      ->orderBy('modulename', 'asc')
                      ->get();

    foreach($modules as $key => $module) :
      $tmp = $modules[$key];
      $modules[$key] = new \stdClass();
      $modules[$key] = $tmp;
      $modules[$key]->submod = self::getModules($tmp->id, implode(",",$inmenu), $idrol);
    endforeach;

    return $modules;
  }

  public static function checkPermission($check, $moduleslug, $type = 'view') {
    $check = (isset($check->roles_id)) ? $check->roles_id : $check->id;
    $permission = RolesAccess::select($type)
                    ->where('roles_id', $check)
                    ->join('modules', 'modules.id', '=', 'roles_access.modules_id')
                    ->where('modules.moduleslug', $moduleslug)
                    ->first();

    if(!isset($permission->{$type})) return $type;

    if($permission->{$type} == 0) return false;
    if($permission->{$type} == 1) return true;
  }

  public static function printSubmenu($submenu, $prefix, $route) {
    if(!empty($submenu)) :
      echo '<ul class="ml-menu">';
      foreach($submenu as $submodule) :
        if(CmsController::checkPermission(Auth::user(), $submodule->modulename) == true) :
      echo '<li';
      //echo (($prefix == $submodule->url and count($submodule->submod) > 0) || $route == $submodule->url) ? ' class="active"' : '';
      echo (stripos($route, $submodule->url)) ? ' class="active"' : '';
      echo '>';
      if(!empty($submodule->submod) and count($submodule->submod) > 0) :
        echo '<a href="javascript:void(0);" class="menu-toggle">';
      else :
        echo '<a href="' . url($submodule->url) . '">';
      endif;
      echo ($route != $submodule->url) ? '<i class="material-icons">' . $submodule->icon . '</i>' : '';
      echo '<span>' . trans('modules.'.$submodule->modulename) .'</span>';
      echo'</a>' ;
      if(isset($submodule->submod) and !empty($submodule->submod) and count($submodule->submod) > 0) self::printSubmenu($submodule->submod, $prefix, $route);
      echo '</li>';
        endif;
      endforeach;
      echo '</ul>';
    endif;
  }

  public static function getDataModule($module, $type) {
    $modules = Modules::select($type)
                ->where('active', 'Y')
                ->where('modulename', $module)
                ->first();

    if(!is_null($modules)) return $modules->{$type};
  }
}

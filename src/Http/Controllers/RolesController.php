<?php

namespace Cogroup\Cms\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Cogroup\Cms\Http\Controllers\CmsController;
use Cogroup\Cms\Models\User;
use Cogroup\Cms\Models\Roles\Roles;
use Cogroup\Cms\Models\Roles\RolesAccess;
use Cogroup\Cms\Models\Modules;

class RolesController extends CmsController {
	/**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {}

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {
    $breadcrumb = array(trans('home'), trans('moduleroles.title'));

    $roles = Roles::select('*')
                  ->where('id', '>=', Auth::user()->roles_id)
                  ->get();

    return view('cogroupcms::modules.roles.body')->with(
      array(
        'user' => Auth::user(),
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'roles' => $roles,
        'breadcrumb' => $breadcrumb,
        'title' => trans('moduleroles.title')
      )
    );
  }

  /**
   * Show the application form add user.
   *
   * @return \Illuminate\Http\Response
   */
  public function add(Request $request) {
    $breadcrumb = array(trans('home'), trans('moduleroles.title'), trans('moduleroles.add'));

    return view('cogroupcms::modules.roles.register')->with(
      array(
        'user' => Auth::user(),
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'breadcrumb' => $breadcrumb,
        'title' => trans('moduleroles.add')
      )
    );
  }

  public function addpost(Request $request) {
    $id = ($request->has('id')) ? $request->input('id') : NULL;
    if(!is_null($id)) Roles::findOrFail($id);
    $validator = Validator::make($request->all(), [
        'rolname' => 'required|max:255',
        'description' => 'required|max:255'
    ]);

    if ($validator->fails()) :
      $url = (is_null($id)) ? 'add' : 'edit';
      return redirect(route('cogroupcms.rol' . $url))
              ->withErrors($validator)
              ->withInput();
    endif;

    $rol = Roles::firstOrNew(['id' => $id]);
    $data = $request->all();
    $rol->id = $id;
    $rol->fill($data);
    // Guardamos el rol
    $rol->save();

    $request->session()->flash('status', '1');
    if(is_null($id)) $request->session()->flash('msg', trans('moduleroles.msgaddok'));
    else $request->session()->flash('msg', trans('moduleroles.msgeditok'));
    return redirect(route('cogroupcms.roleshome'));
  }

  /**
   * Show the user permissions.
   *
   * @return \Illuminate\Http\Response
   */
  public function permissions(Request $request) {
    $breadcrumb = array(trans('home'), trans('moduleroles.title'), trans('moduleroles.permissions'));

    $rol = Roles::where('id', $request->input('id'))->with('RolAccess')->first();
    //exit(var_dump($user->rolesaccess->count()));

    if($rol->rolaccess->count() == 0) :
      RolesAccess::registerRol($rol->id);
      $rol = Roles::where('id', $request->input('id'))->with('RolAccess')->first();
    endif;

    if($rol->rolaccess->count() == 0) :
      $request->session()->flash('status', '0');
      $request->session()->flash('msg', trans('moduleroles.msgpermissionsdontexist'));
      return redirect(route('cogroupcms.roleshome'));
    endif;

    return view('cogroupcms::modules.roles.permissions')->with(
      array(
        'user' => Auth::user(),
        'rolpermissions' => $rol,
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'breadcrumb' => $breadcrumb,
        'modulesrol' => parent::getModules(0, ['Y','N'], $request->input('id'), false),
        'title' => trans('moduleroles.permissions')
      )
    );
  }

  public function setpermission(Request $request) {
    $validator = Validator::make($request->all(), [
        'modules_id' => 'exists:modules,id',
        'roles_id' => 'exists:roles,id',
        'perm' => 'in:view,create,update,delete,public',
        'value' => 'in:0,1'
    ]);

    if ($validator->fails()) :
      return response()
              ->json(['status' => false]);
    endif;

    if(parent::checkPermission(Auth::user(), 'roles', 'update') == false) :
      return response()
              ->json(['status' => false]);
    endif;

    $data = $request->all();
    $rolesaccess = RolesAccess::select('id')
                              ->where('roles_id', $request->input('roles_id'))
                              ->where('modules_id', $request->input('modules_id'))
                              ->first();

    $rolesaccess->{$request->input('perm')} = $request->input('value');

    // Guardamos el permiso
    if($rolesaccess->update())
      return response()->json(['status' => true]);
    else
      return response()->json(['status' => false]);
  }

  /**
   * Show the application form edit user.
   *
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request) {
    $breadcrumb = array(trans('home'), trans('moduleroles.title'), trans('moduleroles.edit'));

    $id = $request->input('id');
    if(empty($id)) $id = $request->old('id');

    $editrol = Roles::findOrFail($id);

    return view('cogroupcms::modules.roles.register')->with(
      array(
        'user' => Auth::user(),
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'breadcrumb' => $breadcrumb,
        'roledit' => $editrol,
        'title' => trans('moduleroles.edit')
      )
    );
  }
}

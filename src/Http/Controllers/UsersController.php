<?php

namespace Cogroup\Cms\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cogroup\Cms\Models\User;
use Cogroup\Cms\Models\Roles\Roles;
use Cogroup\Cms\Http\Controllers\CmsController;


class UsersController extends CmsController {
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
    $breadcrumb = array(trans('cms.home'), trans('moduleusers.title'));

    $users = User::select('*')
                ->where('roles_id', '>=', Auth::user()->roles_id)
                ->where('id', '<>', Auth::user()->id)
                ->get();

    return view('cogroupcms::modules.users.body')->with(
      array(
        'user' => Auth::user(),
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'users' => $users,
        'breadcrumb' => $breadcrumb,
        'title' => trans('moduleusers.title')
      )
    );
  }

  /**
   * Show the application form add user.
   *
   * @return \Illuminate\Http\Response
   */
  public function add(Request $request) {
    $breadcrumb = array(trans('cms.home'), trans('moduleusers.title'), trans('moduleusers.add'));

    return view('cogroupcms::modules.users.register')->with(
      array(
        'user' => Auth::user(),
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'breadcrumb' => $breadcrumb,
        'roles' => Roles::orderBy('id')->get(),
        'title' => trans('moduleusers.add')
      )
    );
  }

  public function addpost(Request $request) {
    $id = ($request->has('id')) ? $request->input('id') : NULL;
    if(!is_null($id)) User::findOrFail($id);
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'email' => ((is_null($id)) ? 'unique:users|' : '' ) . 'required|email|max:255',
        'password' => (is_null($id)) ? 'required|min:6|confirmed' : 'confirmed',
        'roles_id' => 'required|exists:roles,id'
    ]);

    if ($validator->fails()) :
      $url = (is_null($id)) ? 'add' : 'edit';
      return redirect(route('cogroupcms.users' . $url))
              ->withErrors($validator)
              ->withInput();
    endif;

    $user = User::firstOrNew(['id' => $id]);
    $data = $request->all();
    $user->id = $id;
    if(empty($data['password']) and !is_null($id)) :
      $data['password'] = $user->password;
    elseif((!empty($data['password']) and !is_null($id)) || is_null($id)) :
      $data['password'] = bcrypt($data['password']);
    endif;
    $user->fill($data);
    // Guardamos el usuario
    $user->save();

    $request->session()->flash('status', '1');
    if(is_null($id)) $request->session()->flash('msg', trans('moduleusers.msgaddok'));
    else $request->session()->flash('msg', trans('moduleusers.msgeditok'));
    return redirect(route('cogroupcms.usershome'));
  }

  /**
   * Show the application form edit user.
   *
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request) {
    $breadcrumb = array(trans('cms.home'), trans('moduleusers.title'), trans('moduleusers.edit'));

    $id = $request->input('id');
    $edituser = User::findOrFail($id);

    return view('cogroupcms::modules.users.register')->with(
      array(
        'user' => Auth::user(),
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'breadcrumb' => $breadcrumb,
        'roles' => Roles::orderBy('id')->get(),
        'useredit' => $edituser,
        'title' => trans('moduleusers.edit')
      )
    );
  }

  public function active(Request $request) {
    $validator = Validator::make($request->all(), [
        'id' => 'exists:users,id',
        'active' => 'in:Y,N'
    ]);

    if ($validator->fails()) :
      return response()
              ->json(['status' => false]);
    endif;

    $data = $request->all();
    $usersaccess = User::find($request->input('id'));

    $usersaccess->active = $request->input('active');

    // Guardamos el permiso
    if($usersaccess->update())
      return response()->json(['status' => true]);
    else
      return response()->json(['status' => false]);
  }
}
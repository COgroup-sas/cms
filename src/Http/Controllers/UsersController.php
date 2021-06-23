<?php

namespace Cogroup\Cms\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Cogroup\Cms\Models\User;
use Cogroup\Cms\Models\Roles\Roles;
use Cogroup\Cms\Http\Controllers\CmsController;
use Cogroup\Cms\Http\Controllers\FilesController;

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

    $data = $request->all();

    if(!isset($data['roles_id'])) :
      $data['roles_id'] = cms_settings()->defaultrol;
    endif;

    $validator = Validator::make($data, [
        'name' => 'required|max:255',
        'email' => ((is_null($id)) ? 'unique:users|' : '' ) . 'required|email|max:255',
        'password' => (is_null($id)) ? 'required|min:6|confirmed' : 'confirmed',
        'roles_id' => 'required|exists:roles,id'
    ]);

    if ($validator->fails()) :
      if($request->expectsJson()) :
        return ['status' => false, 'error' => $validator->errors()];
      else :
        $url = (is_null($id)) ? 'add' : 'edit';
        return redirect(route('cogroupcms.users.' . $url))
                ->withErrors($validator)
                ->withInput();
      endif;
    endif;

    $user = User::firstOrNew(['id' => $id]);
    $data = $request->all();
    $user->id = $id;
    if(empty($data['password']) and !is_null($id)) :
      $data['password'] = $user->password;
    elseif((!empty($data['password']) and !is_null($id)) || is_null($id)) :
      $data['password'] = Hash::make($data['password']);
    endif;
    $user->fill($data);
    // Guardamos el usuario
    $user->save();

    if(is_null($id)) :
      event(new Registered($user));
    endif;

    if($request->wantsJson()) :
      return ['status' => true, 'user' => $user];
    else :
      $request->session()->flash('status', '1');
      if(is_null($id)) $request->session()->flash('msg', trans('moduleusers.msgaddok'));
      else $request->session()->flash('msg', trans('moduleusers.msgeditok'));
      return redirect(route('cogroupcms.users.home'));
    endif;
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

  /**
   * Show the application form add user.
   *
   * @return \Illuminate\Http\Response
   */
  public function profile(Request $request) {
    $breadcrumb = array(trans('cms.home'), trans('moduleusers.title'), trans('moduleusers.profile'));

    $user = User::with('Roles')->findOrFail(Auth::id());

    if($request->expectsJson()) :
      return $user;
    endif;

    return view('cogroupcms::modules.users.profile')->with(
      array(
        'profile' => $user,
        'breadcrumb' => $breadcrumb,
        'title' => trans('moduleusers.profile')
      )
    );
  }

  public function profilesave(Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'password' => 'confirmed',
        'photo' => 'sometimes|nullable|image|mimetypes:image/jpeg,image/gif,image/png,image/svg+xml'
    ]);

    if ($validator->fails()) :
      if($request->expectsJson()) :
        return ['status' => false, 'error' => $validator->errors()];
      else :
        return redirect(route('cogroupcms.usersprofile'))
                ->withErrors($validator)
                ->withInput();
      endif;
    endif;

    $user = User::findOrFail(Auth::id());
    $data = $request->all();
    if(empty($data['password'])) :
      $data['password'] = $user->password;
    elseif(!empty($data['password'])) :
      $data['password'] = Hash::make($data['password']);
    endif;
    $user->fill($data);
    if ($request->hasFile('photo')) :
      $image = FilesController::upload($request, 'photo');
      if($image['status'] == true) :
        $user->image_id = $image['id'];
      endif;
    endif;
    // Guardamos el usuario
    $user->save();

    if($request->wantsJson()) :
      return $user;
    endif;

    $request->session()->flash('status', '1');
    $request->session()->flash('msg', trans('moduleusers.profileok'));
    return redirect(route('cogroupcms.usersprofile'));
  }

  /**
   * Get the user from ajax request
   *
   * @return \Illuminate\Http\Response
   */
  public function getUsers(Request $request) {
    if($request->wantsJson()) :
      $users = User::select(DB::Raw('id As value'), DB::Raw('name AS text'))->where('name', 'like', '%'.$request->input('q').'%')->orderBy('name', 'asc')->get();

      return response()->json($users);
    else :
      return abort(403, trans('cms.403'));
    endif;
  }



  /**
  * Show the application's login form.
  *
  * @return \Illuminate\Http\Response
  */
  public function showRegistrationForm()
  {
    return view('cogroupcms::auth.register');
  }

  /**
   * Api functions
   */

  /**
   * function login for api routes
   * @param  Request $request
   * @return json response
   */
  public function loginApi(Request $request) {
    $credentials = $request->only('email', 'password') + ['active' => 'Y'];

    if ( !Auth::attempt($credentials) ) :
      return response()->json([
        'message' => 'Invalid login details'
      ], 401);
    endif;

    $user = User::where('email', $request['email'])->firstOrFail();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'access_token' => $token,
      'token_type' => 'Bearer',
    ]);
  }

  public function logoutApi() {

  }
}

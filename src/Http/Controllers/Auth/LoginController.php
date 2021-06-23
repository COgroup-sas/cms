<?php

namespace Cogroup\Cms\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cogroup\Cms\Models\Roles\Roles;
use Cogroup\Cms\Models\User;

use Socialite;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  /**
   * Redirect the user to the GitHub authentication page.
   *
   * @return \Illuminate\Http\Response
   */
  public function redirectToProvider($service)
  {
    switch($service) :
      case 'google'   :
      case 'facebook' :
      case 'zoho'     :
      case 'graph'    :
      case 'yahoo'    :
      case 'twitter'  :
      case 'linkedin' :
        return Socialite::driver($service)->redirect();
        break;
      default         :
        return abort(404);
      break;
    endswitch;
  }

  /**
   * Obtain the user information from GitHub.
   *
   * @return \Illuminate\Http\Response
   */
  public function handleProviderCallback($service)
  {
    try {
      if($service == 'facebook') :
        $social_user = Socialite::driver($service)->fields(['first_name', 'last_name', 'name', 'email', 'gender'])->user();
      elseif($service == 'google') :
        $social_user = Socialite::driver($service)->stateless()->user();
      else :
        $social_user = Socialite::driver($service)->user();
      endif;

      switch($service) :
        case 'google' :
          $name = $social_user->user['given_name'];
          $lastname = $social_user->user['family_name'];
          $mail = $social_user->getEmail();
          break;
        case 'facebook' :
          $name = $social_user->user['first_name'];
          $lastname = $social_user->user['last_name'];
          $mail = $social_user->getEmail();
          break;
        case 'zoho' :
          $name = $social_user->user['First_Name'];
          $lastname = $social_user->user['Last_Name'];
          $mail = $social_user->getEmail();
          break;
        case 'graph' :
          $name = $social_user->user['givenName'];
          $lastname = $social_user->user['surname'];
          $mail = $social_user->user['userPrincipalName'];
          break;
        case 'yahoo' :
          $name = $social_user->user['given_name'];
          $lastname = $social_user->user['family_name'];
          $mail = $social_user->getEmail();
          break;
        case 'twitter' :
        case 'linkedin':
          $name = explode(" ", $social_user->name);
          switch(count($name)) :
            case 1 :
              $name = $name[0];
              $lastname = '';
              break;
            case 2 :
              $name = $name[0];
              $lastname = $name[1];
              break;
            case 3 :
              $name = $name[0];
              $lastname = implode(" ", [$name[1], $name[2]]);
              break;
            case 4 :
              $name = implode(" ", [$name[0], $name[1]]);
              $lastname = implode(" ", [$name[2], $name[3]]);
              break;
            default :
              $name = implode(" ", [$name[0], $name[1], $name[2]]);
              $lastname = implode(" ", [$name[3], $name[4]]);
              break;
          endswitch;
          $mail = $social_user->getEmail();
          break;
      endswitch;

      if(is_null($mail) || empty($mail)) :
        return abort(403);
      endif;

      if ($user = User::where('email', $mail)->first()) :
        if($social_user->avatar != $user->avatar) :
          $user->avatar = $social_user->avatar;
          $user->social = 'Y';
          $user->save();
        endif;
        return $this->authAndRedirect($user); // Login y redirección
      else :
        if(cms_settings()->enableregisteruser == 1) :
          // En caso de que no exista creamos un nuevo usuario con sus datos.
          $user = User::create([
            'name' => $name,
            'lastname' => $lastname,
            'email' => $mail,
            'avatar' => $social_user->avatar,
            'social' => 'Y',
            'roles_id' => cms_settings()->defaultrol
          ]);

          return $this->authAndRedirect($user); // Login y redirección
        else :
          return back()->withErrors([
            'email' => trans('moduleusers.registerinactive'),
          ]);
        endif;
      endif;
    } catch(Exception $e) {
      report($e);
      return abort(404);
    }
  }

  // Login y redirección
  public function authAndRedirect($user)
  {
    Auth::login($user);

    return redirect()->to(config('cogroupcms.uri'));
  }

  /**
   * Show the application's login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function showLoginForm()
  {
    return view('cogroupcms::auth.login');
  }

  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function credentials(Request $request)
  {
    return $request->only($this->username(), 'password') + ['active' => 'Y'];
  }
}
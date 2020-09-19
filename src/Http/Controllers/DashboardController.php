<?php

namespace Cogroup\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cogroup\Cms\Models\Settings;
use Cogroup\Cms\Models\Roles\Roles;
use Cogroup\Cms\Http\Controllers\CmsController;
use Cogroup\Cms\Models\DatabaseNotification;
use Cogroup\Cms\Models\User;
use Validator;

class DashboardController extends CmsController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $class = config("cogroupcms.dashboard");

        $breadcrumb = array();

        if(empty($class)) :
          return view('cogroupcms::modules.dashboard.body')->with(
            array(
              'user' => Auth::user(),
              'scripts' => $this->scripts,
              'csss' => $this->csss,
              'breadcrumb' => $breadcrumb,
              'title' => trans('cms.home')
            )
          );
        else :
          $object = new $class;
          return call_user_func([$object, "index"]);
        endif;
    }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function settings(Request $request) {
    $breadcrumb = array('settings');

    return view('cogroupcms::modules.dashboard.settings')->with(
      array(
        'user' => Auth::user(),
        'scripts' => $this->scripts,
        'csss' => $this->csss,
        'breadcrumb' => $breadcrumb,
        'roles' => Roles::orderBy('id')->get(),
        'title' => trans('modulesettings.title')
      )
    );
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function settingstore(Request $request) {
    $validator = Validator::make($request->all(), [
      "sitename" => "required",
      "emailname" => "required",
      "emailaddress" => "required|email",
      "timeformat" => "required",
      "dateformat" => "required",
      "sitedescription" => "required",
      "sitekeywords" => "required",
      "address" => "required",
      "phone" => "required|phone",
      "mobilephone" => "mobilephone",
      'favicon' => 'sometimes|nullable|image|mimetypes:image/jpeg,image/gif,image/png,image/svg+xml',
      'logo' => 'sometimes|nullable|image|mimetypes:image/jpeg,image/gif,image/png,image/svg+xml',
      'logocontraste' => 'sometimes|nullable|image|mimetypes:image/jpeg,image/gif,image/png,image/svg+xml',
      'defaultrol' => 'required|exists:roles,id'
    ]);

    if ($validator->fails()) :
      $url = route('cogroupcms.settings.home');
      return redirect($url)
              ->withErrors($validator)
              ->withInput();
    endif;

    $data = $request->all();
    $data['socialaccess'] = (isset($data['socialaccess'])) ? $data['socialaccess'] : 0;
    $data['socialaccessgoogle'] = (isset($data['socialaccessgoogle'])) ? $data['socialaccessgoogle'] : 0;
    $data['socialaccessfacebook'] = (isset($data['socialaccessfacebook'])) ? $data['socialaccessfacebook'] : 0;
    $data['socialaccesstwitter'] = (isset($data['socialaccesstwitter'])) ? $data['socialaccesstwitter'] : 0;
    $data['socialaccesslinkedin'] = (isset($data['socialaccesslinkedin'])) ? $data['socialaccesslinkedin'] : 0;
    $datos = array();
    foreach($data as $key => $dat) :
      $id = Settings::where('setting', $key)->value('id');
      if(!is_null($id)) :
        $settings = Settings::find($id);
        $settings->setting = $key;
        $settings->defaultvalue = $dat;
        $settings->save();
      endif;
    endforeach;

    if ($request->hasFile('favicon')) :
      $image = FilesController::upload($request, 'favicon');
      if($image['status'] == true) :
        $id = Settings::where('setting', 'favicon')->value('id');
        if(!is_null($id)) :
          $settings = Settings::find($id);
          $settings->setting = 'favicon';
          $settings->defaultvalue = $image['id'];;
          $settings->save();
        endif;
      endif;
    endif;

    if ($request->hasFile('logo')) :
      $image = FilesController::upload($request, 'logo');
      if($image['status'] == true) :
        $id = Settings::where('setting', 'logo')->value('id');
        if(!is_null($id)) :
          $settings = Settings::find($id);
          $settings->setting = 'logo';
          $settings->defaultvalue = $image['id'];;
          $settings->save();
        endif;
      endif;
    endif;

    if ($request->hasFile('logocontraste')) :
      $image = FilesController::upload($request, 'logocontraste');
      if($image['status'] == true) :
        $id = Settings::where('setting', 'logocontraste')->value('id');
        if(!is_null($id)) :
          $settings = Settings::find($id);
          $settings->setting = 'logocontraste';
          $settings->defaultvalue = $image['id'];
          $settings->save();
        endif;
      endif;
    endif;

    $request->session()->flash('status', '1');
    $request->session()->flash('msg', trans('modulesettings.msgaddok'));
    return redirect(route('cogroupcms.settings.home'));
  }

  public function notifications() {
    $notifications = User::find(Auth::id())->notifications;
    $breadcrumb = [trans('home'), trans('notifications.title')];

    return view('cogroupcms::modules.notifications.notifications')->with(
      [
        'user' => auth()->user(),
        'breadcrumb' => $breadcrumb,
        'title' => trans('notifications.title'),
        'notifications' => $notifications
      ]
    );
  }

  public function notificationsReadAll() {
    User::find(auth()->user()->id)->unreadNotifications->markAsRead();

    return back();
  }

  public function notification(DatabaseNotification $notification) {
    abort_unless($notification->associatedTo(User::find(auth()->user()->id)), 404);

    $notification->markAsRead();

    return redirect(route('cogroupcms.notifications.home'));
  }

  public function notificationsDelete() {
    User::find(auth()->user()->id)->notifications()->delete();

    return back();
  }
}

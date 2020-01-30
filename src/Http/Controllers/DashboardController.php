<?php

namespace Cogroup\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cogroup\Cms\Models\Settings;
use Cogroup\Cms\Http\Controllers\CmsController;
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
      'logo' => 'sometimes|nullable|image|mimetypes:image/jpeg,image/gif,image/png,image/svg+xml'
    ]);

    if ($validator->fails()) :
      $url = route('cogroupcms.settings');
      return redirect($url)
              ->withErrors($validator)
              ->withInput();
    endif;

    $data = $request->all();
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

    $request->session()->flash('status', '1');
    $request->session()->flash('msg', trans('modulesettings.msgaddok'));
    return redirect(route('cogroupcms.settings'));
  }
}

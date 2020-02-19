<?php

use Illuminate\Support\Facades\Route;
use Cogroup\Cms\Models\DatabaseNotification;
use Cogroup\Cms\Models\User;


Route::group(['middleware' => ['web'],
              'namespace' => 'Cogroup\Cms\Http\Controllers'
  ], function () {
  Auth::routes();

  Route::prefix('login')->group(function () {
    Route::get('{service}', 'Auth\LoginController@redirectToProvider');
    Route::get('{service}/callback', 'Auth\LoginController@handleProviderCallback');
  });

  Route::group(['prefix' => 'files'], function () {
    Route::get('thumb/{id}/{height?}/{width?}', 'FilesController@processFileThumb')->name('thumb');
    Route::get('{id}', 'FilesController@processFile')->name('getFile');
  });

  Route::group(['prefix' => config('cogroupcms.uri', 'cms'),
                'middleware' => ['auth']
    ], function () {
      Route::get('/','DashboardController@index')->name('cogroupcms.home');

      Route::group(['prefix' => 'settings', 'middleware' => ['admin:settings|view']], function () {
        Route::get('/', ['uses' => 'DashboardController@settings'])->name('cogroupcms.settings');
        Route::post('/', ['middleware' => ['admin:settings|update'], 'uses' => 'DashboardController@settingstore'])->name('cogroupcms.settingsave');
      });
      Route::group(['prefix' => 'roles', 'middleware' => ['admin:roles|view']], function () {
        Route::get('/', ['uses' => 'RolesController@index'])->name('cogroupcms.roleshome');
        Route::get('add', ['middleware' => ['admin:roles|create'], 'uses' => 'RolesController@add'])->name('cogroupcms.roladd');
        Route::post('add', ['middleware' => ['admin:roles|create:update'], 'uses' => 'RolesController@addpost'])->name('cogroupcms.rolpost');
        Route::post('permissions', 'RolesController@permissions')->name('cogroupcms.rolpermissions');
        Route::post('setpermission', ['middleware' => ['admin:roles|update'], 'uses' => 'RolesController@setPermission'])->name('cogroupcms.rolsetpermission');
        Route::match(['get', 'post'], 'edit', ['middleware' => ['admin:roles|update'], 'uses' => 'RolesController@edit'])->name('cogroupcms.roledit');
      });
      Route::group(['prefix' => 'users', 'middleware' => ['admin:users|view']], function () {
        Route::get('/', ['uses' => 'UsersController@index'])->name('cogroupcms.usershome');
        Route::get('add', ['middleware' => ['admin:users|create'], 'uses' => 'UsersController@add'])->name('cogroupcms.usersadd');
        Route::post('add',  ['middleware' => ['admin:users|create,update'], 'uses' => 'UsersController@addpost'])->name('cogroupcms.userspost');
        Route::post('edit',  ['middleware' => ['admin:users|update'], 'uses' => 'UsersController@edit'])->name('cogroupcms.usersedit');
        Route::post('active',  ['middleware' => ['admin:users|update'], 'uses' => 'UsersController@active'])->name('cogroupcms.usersactive');
        Route::get('getUsers',  'UsersController@getUsers')->name('cogroupcms.usersajax');
      });
      Route::get('profile',  'UsersController@profile')->name('cogroupcms.usersprofile');
      Route::post('profile',  'UsersController@profilesave')->name('cogroupcms.usersprofilesave');

      Route::get('notifications', function () {
        $notifications = User::find(auth()->user()->id)->notifications;
        $breadcrumb = [trans('home'), trans('notifications.title')];

        return view('cogroupcms::modules.notifications.notifications')->with(
          [
            'user' => auth()->user(),
            'breadcrumb' => $breadcrumb,
            'title' => trans('notifications.title'),
            'notifications' => $notifications
          ]
        );
      })->name('notifications');

      Route::get('notifications/read-all', function () {
        User::find(auth()->user()->id)->unreadNotifications->markAsRead();

        return back();
      })->name('notifications.readall');

      Route::get('notifications/{notification}', function (DatabaseNotification $notification) {
        abort_unless($notification->associatedTo(User::find(auth()->user()->id)), 404);

        $notification->markAsRead();

        return redirect(route('notifications'));
      })->name('notifications.notification');
  });
});
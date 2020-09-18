<?php

use Illuminate\Support\Facades\Route;
use Cogroup\Cms\Models\DatabaseNotification;
use Cogroup\Cms\Models\User;


Route::group(['middleware' => ['web'],
              'namespace' => 'Cogroup\Cms\Http\Controllers'
  ], function () {

  /*Auth Routes*/
  Route::prefix('login')->group(function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Auth\LoginController@login');
    Route::get('{service}', 'Auth\LoginController@redirectToProvider');
    Route::get('{service}/callback', 'Auth\LoginController@handleProviderCallback');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
  });
  Route::prefix('password')->group(function () {
    Route::get('confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('confirm', 'Auth\ConfirmPasswordController@confirm');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    Route::prefix('reset')->group(function() {
      Route::get('/', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
      Route::post('/', 'Auth\ForgotPasswordController@reset')->name('password.update');
      Route::get('{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.reset');
    });
  });
  Route::prefix('register')->group(function() {
    Route::get('/', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/', 'Auth\RegisterController@register');
  });

  Route::prefix('files')->group(function () {
    Route::get('thumb/{id}/{height?}/{width?}', 'FilesController@processFileThumb')->name('thumb');
    Route::get('{id}', 'FilesController@processFile')->name('getFile');
  });

  Route::prefix(config('cogroupcms.uri', 'cms'))->middleware(['auth'])->group(function () {
      Route::get('/','DashboardController@index')->name('cogroupcms.home');

      Route::prefix('settings')->middleware(['admin:settings|view'])->group(function () {
        Route::get('/', ['uses' => 'DashboardController@settings'])->name('cogroupcms.settings');
        Route::post('/', ['middleware' => ['admin:settings|update'], 'uses' => 'DashboardController@settingstore'])->name('cogroupcms.settingsave');
      });
      Route::prefix('roles')->middleware(['admin:roles|view'])->group(function () {
        Route::get('/', ['uses' => 'RolesController@index'])->name('cogroupcms.roleshome');
        Route::get('add', ['middleware' => ['admin:roles|create'], 'uses' => 'RolesController@add'])->name('cogroupcms.roladd');
        Route::post('add', ['middleware' => ['admin:roles|create:update'], 'uses' => 'RolesController@addpost'])->name('cogroupcms.rolpost');
        Route::post('permissions', 'RolesController@permissions')->name('cogroupcms.rolpermissions')->name('cogroupcms.roles.permissions');
        Route::post('setpermission', ['middleware' => ['admin:roles|update'], 'uses' => 'RolesController@setPermission'])->name('cogroupcms.rolsetpermission');
        Route::match(['get', 'post'], 'edit', ['middleware' => ['admin:roles|update'], 'uses' => 'RolesController@edit'])->name('cogroupcms.roledit');
      });
      Route::prefix('users')->middleware(['admin:users|view'])->group(function () {
        Route::get('/', ['uses' => 'UsersController@index'])->name('cogroupcms.usershome');
        Route::get('add', ['middleware' => ['admin:users|create'], 'uses' => 'UsersController@add'])->name('cogroupcms.usersadd');
        Route::post('add',  ['middleware' => ['admin:users|create,update'], 'uses' => 'UsersController@addpost'])->name('cogroupcms.userspost');
        Route::post('edit',  ['middleware' => ['admin:users|update'], 'uses' => 'UsersController@edit'])->name('cogroupcms.usersedit');
        Route::post('active',  ['middleware' => ['admin:users|update'], 'uses' => 'UsersController@active'])->name('cogroupcms.usersactive');
        Route::get('getUsers',  'UsersController@getUsers')->name('cogroupcms.usersajax');
      });
      Route::get('profile',  'UsersController@profile')->name('cogroupcms.usersprofile');
      Route::post('profile',  'UsersController@profilesave')->name('cogroupcms.usersprofilesave');

      Route::prefix('notifications')->group(function() {
        Route::get('/', 'DashboardController@notifications')->name('notifications.home');
        Route::get('read-all', 'DashboardController@notificationsReadAll')->name('notifications.readall');
        Route::get('delete', 'DashboardController@notificationsDelete')->name('notifications.delete');
        Route::get('{notification}', 'DashboardController@notification')->name('notifications.notification');
      });
  });
});
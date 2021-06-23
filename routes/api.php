<?php

use Illuminate\Support\Facades\Route;
use Cogroup\Cms\Models\DatabaseNotification;
use Cogroup\Cms\Models\User;


/*Auth Routes*/
Route::prefix('register')->middleware(['cogroupcmsregister'])->group(function() {
  Route::post('/', 'Auth\RegisterController@register')->name('register.api');
});
Route::prefix('login')->group(function () {
  Route::post('/', 'UsersController@loginApi');
  //Route::get('{service}', 'Auth\LoginController@redirectToProvider');
  //Route::get('{service}/callback', 'Auth\LoginController@handleProviderCallback');
  Route::post('logout', 'UsersController@logoutApi')->name('logoutapi');
});
Route::prefix('password')->group(function () {
  Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email.api');
  Route::post('confirm', 'Auth\ConfirmPasswordController@confirm');

  Route::prefix('reset')->group(function() {
    Route::post('/', 'Auth\ResetPasswordController@reset')->name('password.update.api');
  });
});

Route::name('files.')->prefix('files')->group(function () {
  Route::get('thumb/{id}/{height?}/{width?}', 'FilesController@processFileThumb')->name('thumb.api');
  Route::get('{id}', 'FilesController@processFile')->name('getFile.api');
});

Route::name('cogroupcmsapi.')
     ->prefix(config('cogroupcms.uri', 'cms'))
     ->middleware(['auth:sanctum'])
     ->group(function () {
  /*Route::name('settings.')->prefix('settings')->middleware(['admin:settings|view'])->group(function () {
    Route::get('/', ['uses' => 'DashboardController@settings'])->name('home');
    Route::post('/', ['middleware' => ['admin:settings|update'], 'uses' => 'DashboardController@settingstore'])->name('save');
  });
  Route::name('roles.')->prefix('roles')->middleware(['admin:roles|view'])->group(function () {
    Route::get('/', ['uses' => 'RolesController@index'])->name('home');
    Route::get('add', ['middleware' => ['admin:roles|create'], 'uses' => 'RolesController@add'])->name('add');
    Route::post('add', ['middleware' => ['admin:roles|create:update'], 'uses' => 'RolesController@addpost'])->name('save');
    Route::post('permissions', 'RolesController@permissions')->name('permissions');
    Route::post('setpermission', ['middleware' => ['admin:roles|update'], 'uses' => 'RolesController@setPermission'])->name('setpermission');
    Route::match(['get', 'post'], 'edit', ['middleware' => ['admin:roles|update'], 'uses' => 'RolesController@edit'])->name('edit');
  });
  Route::name('users.')->prefix('users')->middleware(['admin:users|view'])->group(function () {
    Route::get('/', ['uses' => 'UsersController@index'])->name('home');
    Route::get('add', ['middleware' => ['admin:users|create'], 'uses' => 'UsersController@add'])->name('add');
    Route::post('add',  ['middleware' => ['admin:users|create,update'], 'uses' => 'UsersController@addpost'])->name('save');
    Route::post('edit',  ['middleware' => ['admin:users|update'], 'uses' => 'UsersController@edit'])->name('edit');
    Route::post('active',  ['middleware' => ['admin:users|update'], 'uses' => 'UsersController@active'])->name('active');
    Route::get('getUsers',  'UsersController@getUsers')->name('userslist');
  });*/
  Route::get('profile',  'UsersController@profile')->name('usersprofileapi');
  Route::post('profile',  'UsersController@profilesave')->name('usersprofilesaveapi');

  /*Route::name('notifications.')->prefix('notifications')->group(function() {
    Route::get('/', 'DashboardController@notifications')->name('home');
    Route::get('read-all', 'DashboardController@notificationsReadAll')->name('readall');
    Route::get('delete', 'DashboardController@notificationsDelete')->name('delete');
    Route::get('{notification}', 'DashboardController@notification')->name('notification');
  });*/
});
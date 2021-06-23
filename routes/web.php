<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Cogroup\Cms\Models\DatabaseNotification;
use Cogroup\Cms\Models\User;


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
    Route::post('/', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.reset');
  });
});
Route::prefix('register')->middleware(['cogroupcmsregister'])->group(function() {
  Route::get('/', 'Auth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/', 'Auth\RegisterController@register');
});
Route::get('/email/verify', function () {
  return view('cogroupcms::auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();

  return redirect(config('cogroupcms.uri', 'cms'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', trans('cms.register.textresendverificationlink'));
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/* route to file */
Route::name('files.')->prefix('files')->group(function () {
  Route::get('thumb/{id}/{height?}/{width?}', 'FilesController@processFileThumb')->name('thumb');
  Route::get('{id}', 'FilesController@processFile')->name('getFile');
});

Route::name('cogroupcms.')
     ->prefix(config('cogroupcms.uri', 'cms'))
     ->middleware(['auth', 'verified'])
     ->group(function () {
  Route::get('/','DashboardController@index')->name('home');

  Route::name('settings.')->prefix('settings')->middleware(['admin:settings|view'])->group(function () {
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
    Route::get('getUsers',  'UsersController@getUsers')->name('ajax');
  });
  Route::get('profile',  'UsersController@profile')->name('usersprofile');
  Route::post('profile',  'UsersController@profilesave')->name('usersprofilesave');

  Route::name('notifications.')->prefix('notifications')->group(function() {
    Route::get('/', 'DashboardController@notifications')->name('home');
    Route::get('read-all', 'DashboardController@notificationsReadAll')->name('readall');
    Route::get('delete', 'DashboardController@notificationsDelete')->name('delete');
    Route::get('{notification}', 'DashboardController@notification')->name('notification');
  });
});

Route::fallback(function() {
  return abort(404);
});
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web'],
              'namespace' => 'Cogroup\Cms\Http\Controllers'
  ], function () {
  Auth::routes();

  Route::prefix('login')->group(function () {
    Route::get('{service}', 'Auth\LoginController@redirectToProvider');
    Route::get('{service}/callback', 'Auth\LoginController@handleProviderCallback');
  });

  Route::group(['prefix' => config('cogroupcms.uri', 'cms'),
                'middleware' => ['admin', 'auth']
    ], function () {
      Route::get('/', 'DashboardController@index')->name('cogroupcms.home');

      Route::group(['prefix' => 'settings'], function () {
        Route::get('/', ['uses' => 'DashboardController@settings'])->name('cogroupcms.settings');
        Route::post('/', 'DashboardController@settingstore')->name('cogroupcms.settingsave');
      });
      Route::group(['prefix' => 'roles'], function () {
        Route::get('/', ['uses' => 'RolesController@index'])->name('cogroupcms.roleshome');
        Route::get('add', 'RolesController@add')->name('cogroupcms.roladd');
        Route::post('add', 'RolesController@addpost')->name('cogroupcms.rolpost');
        Route::post('permissions', 'RolesController@permissions')->name('cogroupcms.rolpermissions');
        Route::post('setpermission', 'RolesController@setPermission')->name('cogroupcms.rolsetpermission');
        Route::match(['get', 'post'], 'edit', 'RolesController@edit')->name('cogroupcms.roledit');
      });
      Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['uses' => 'UsersController@index'])->name('cogroupcms.usershome');
        Route::get('add', 'UsersController@add')->name('cogroupcms.usersadd');
        Route::post('add', 'UsersController@addpost')->name('cogroupcms.userspost');
        Route::post('edit', 'UsersController@edit')->name('cogroupcms.usersedit');
        Route::post('active', 'UsersController@active')->name('cogroupcms.usersactive');
      });
  });
});
<p align="center"><img src="https://www.cogroupsas.com/wp-content/uploads/2018/02/logo_azul.png"></p>

<p align="center">
<a href="https://packagist.org/packages/cogroup/cms"><img src="https://www.cogroupsas.com/gitimages/version.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/cogroup/cms"><img src="https://www.cogroupsas.com/gitimages/license.svg" alt="License"></a>
</p>

# Cms

##CMS package for laravel

### For Laravel < 5.7, please use the [1.6 branch](https://github.com/COgroup-sas/cms/tree/1.6)!

COgroup - CMS package is a flexible way to add basic CMS system with Role-based Permissions to **Laravel 5**.

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
    - [User relation to roles](#user-relation-to-roles)
    - [Models](#models)
        - [Files](#files)
        - [Modules](#modules)
        - [No Working Days](#noworkingdays)
        - [Roles](#roles)
        - [Roles Access](#rolesaccess)
        - [Settings](#settings)
        - [User](#user)
    - [Intervention Image](#interventionimage)
- [Usage](#usage)
    - [Middleware](#middleware)
    - [Helper Permission](#helper-permission)
    - [Helpers](#helpers)
        - [cms_get_modules](#cms_get_modules)
        - [cms_settings](#cms_settings)
        - [cms_format_date](#cms_format_date)
        - [cms_format_time](#cms_format_time)
        - [cms_format_datetime](#cms_format_datetime)
        - [cms_get_file_attribute](#cms_get_file_attribute)
    - [Notifications javascript](#notifications-javascript)
- [License](#license)
- [Contribution guidelines](#contribution-guidelines)
- [Additional information](#additional-information)

## Installation

1) In order to install COgroup - CMS, just add the following to your composer.json. Then run `composer update`:

```json
"cogroup/cms": "1.7-dev"
```
or run the next command:
```json
composer require cogroup/cms
```

2) Run the command below to publish the package config file `config/cogroupcms.php`:

```shell
php artisan vendor:publish --provider="Cogroup\Cms\CmsServiceProvider"
```

3)  Run the command below to execute migrations

```php
php artisan migrate
```

4)  Run the command below to seed

```php
php artisan db:seed --class=Cogroup\\Cms\\Seeds\\CogroupCmsSeeder
```

5)  Run the command below to re-publish assets, config, custom error views, font, migrations and translations

```php
php artisan cogroupcms::assets
php artisan cogroupcms::config
php artisan cogroupcms::errorviews
php artisan cogroupcms::fonts
php artisan cogroupcms::migrations
php artisan cogroupcms::translations
```

## Configuration

Set the property values in the `config/cogroupcms.php`.
These values will be used by cogroup-cms to refer to the correct prefix, color theme and URI to CMS access.

### User relation to roles

You may now run it with the artisan migrate command:

```bash
php artisan migrate
```

After the migration, seven new tables will be present:
- `files` &mdash; manage files into CMS
- `modules` &mdash; modules for CMS
- `noworkingdays` &mdash; dates for special days, and to be able to discount in a range of dates
- `roles` &mdash; roles for CMS
- `roles_access` &mdash; relations between roles and modules access
- `settings` &mdash; CMS basic settings (sitename, emailname, etc.)
- `user` &mdash; Table for users and specific rol user

### Models

#### Files

The `Files` model has eight main attributes:
- `originalname` &mdash; Original name of the file.
- `diskname` &mdash; name of the file into system after upload.
- `extension` &mdash; extension of the file.
- `size` &mdash; size of the file.
- `mimetype` &mdash; Mime type of the file.
- `alt` &mdash; Texto for label alt in HTML.
- `width` &mdash; when is image, a width attribute.
- `height` &mdash; when is image, a height attribute.
- `ispublic` &mdash; determines whether a file is public or not.
- `created_at` &mdash; determines the creation date.
- `updated_at` &mdash; determine the update date.

#### Modules

The `Modules` model has ten main attributes:
- `moduleslug` &mdash; Slug name for the module, to verify permissions.
- `modulename` &mdash; Module name to show.
- `description` &mdash; A more detailed explanation of what the Module does.
- `active` &mdash; module is active or not.
- `url` &mdash; url to acces the module. The url should not have the domain.
- `icon` &mdash; font icon of the module.
- `parent` &mdash; When is a submodule, id of the parent module. When is a father module is 0.
- `order` &mdash; order to show module in the menu.
- `inmenu` &mdash; determines if the module is show in the main menu.
- `permissions` &mdash; Determine what permissions the module needs. They must be separated by commas. Example: "view, create".

#### NoWorkingDays

The `NoWorkingDays` model has two main attributes:
- `date` &mdash; special day date.
- `active` &mdash; determines whether a date is active or not.
- `created_at` &mdash; determines the creation date.
- `updated_at` &mdash; determine the update date.

#### Roles

The `Role` model has two main attributes:
- `rolname` &mdash; Unique name for the Role, used for looking up role information in the application layer. For example: "admin", "owner", "employee".
- `description` &mdash; A more detailed explanation of what the Role does.
- `created_at` &mdash; determines the creation date.
- `updated_at` &mdash; determine the update date.

#### RolesAccess

The `RolesAccess` model has six main attributes:
- `roles_id` &mdash; Unique key for the Role, used for relation to table roles.
- `modules_id` &mdash; Unique key for the modules, used for relation to table modules.
- `view` &mdash; Set the permission to see a module or submodule.
- `create` &mdash; Set the permission to create content in a module or submodule.
- `update` &mdash; Set the permission to update content in a module or submodule.
- `delete` &mdash; Set the permission to delete content in a module or submodule.
- `created_at` &mdash; determines the creation date.
- `updated_at` &mdash; determine the update date.

#### Settings

The `Settings` model has two main attributes:
- `setting` &mdash; Unique name for the setting.
- `defaultvalue` &mdash; A value for the setting attribute.

#### User

This will enable the relation with `Role`.

**And you are ready to go.**

### InterventionImage

After you have installed Intervention Image, open your Laravel config file `config/app.php` and add the following lines.

In the `$providers` array add the service providers for this package.
  
`Intervention\Image\ImageServiceProvider::class`

Add the facade of this package to the $aliases array.
  
`'ImageManager' => Intervention\Image\Facades\Image::class`

Now the Image Class will be auto-loaded by Laravel.

#### Publish configuration in Laravel 5

```php
$ php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"
```

## Usage

### Middleware

You can use a middleware to filter routes and route groups by permission or role
```php
Route::group(['prefix' => 'settings', 'middleware' => ['admin:settings|view']], function() {
    Route::get('/', 'AdminController@welcome');
    Route::post('/', ['middleware' => ['admin:settings|create,update'], 'uses' => 'AdminController@manageAdmins']);
});
```

It is possible to use comma symbol to verify until two actions:
```php
'middleware' => ['role:admin|create,update']
```

### Helper Permission

You can use a helper to verify a permission
```php
cms_roles_check($check, $moduleslug, $type);
```

- `check` is a Auth::user info or module id.
- `moduleslug` is a slug of the module to check permission.
- `type` is optional permission, by default it is `view`.

## Helpers

Cogroup - CMS includes a two "helper" PHP functions. These functions are used by the package itself; however, you are free to use them in your own applications if you find them convenient.

### cms_get_modules

This function return a modules of the system, register into table `modules`.

```php
cms_get_modules($modulename, $inmenu, $idrol);
```

- `modulename` is optional parameter. If is NULL return all modules.
- `inmenu` By default it is `Y`. The other option is `N`.
- `idrol` is optional parameter, by default it is `NULL`. When present, it returns the modules associated with the role that have permission `view`

### cms_settings

This function return a object with settings values

```php
cms_settings();
```

Example: `cms_settings()->sitename`

### cms_format_date

This function return a Carbon format date with the dateformat setting format

```php
cms_format_date($date);
```

- `date` is required parameter. The date format must be Y-m-d.

### cms_format_time

This function return a Carbon format date with the timeformat setting format

```php
cms_format_time($time);
```

- `time` is required parameter. The time format must be H:i:s.

### cms_format_datetime

This function return a Carbon format date with the dateformat and timeformat setting format

```php
cms_format_datetime($datetime);
```

- `datetime` is required parameter. The date format must be Y-m-d H:i:s.

### cms_get_file_attribute

This function return a attribute FileModel

```php
cms_get_file_attribute($id, $attribute);
```

- `id` is required parameter. Id into table `Files`
- `attribute` is required parameter. Column of the table `Files`

## Notifications Javascript

This configuration to set a float message from Controller

Set 1 to info, 0 to danger
```php
$request->session()->flash('status', '1');
```

Set a position (top, middle, bottom)
```php
$request->session()->flash('msgfrom', {position});
```

Set a align (left, middle, right)
```php
$request->session()->flash('msgfrom', {align});
```

Set delay time (default: 4000)
```php
$request->session()->flash('msgtime', {time});
```

Set a message
```php
$request->session()->flash('msg', {message});
```

## License

COgroup CMS is free software distributed under the terms of the MIT license.

## Contribution guidelines

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.
Pull requests are welcome.
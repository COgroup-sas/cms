# Cms

CMS package for laravel &gt;= 5.6


[![Version](https://www.cogroupsas.com/gitimages/version.svg)](https://cogroupsas.com/cms)
[![License](https://www.cogroupsas.com/gitimages/license.svg)](https://packagist.org/packages/cogroup/cms)

COgroup - CMS package is a flexible way to add basic CMS system with Role-based Permissions to **Laravel 5**.

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
    - [User relation to roles](#user-relation-to-roles)
    - [Models](#models)
        - [Role](#role)
        - [Permission](#permission)
        - [User](#user)
- [Usage](#usage)
    - [Middleware](#middleware)
- [License](#license)
- [Contribution guidelines](#contribution-guidelines)
- [Additional information](#additional-information)

## Installation

1) In order to install Laravel 5 Entrust, just add the following to your composer.json. Then run `composer update`:

```json
"cogroup/cms": "1.0.x-dev"
```

2) Run the command below to publish the package config file `config/cogroupcms.php`:

```shell
php artisan vendor:publish
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
These values will be used by cogroup-cms to refer to the correct prefix and color theme.

### User relation to roles

You may now run it with the artisan migrate command:

```bash
php artisan migrate
```

After the migration, four new tables will be present:
- `modules` &mdash; modules for CMS
- `noworkingdays` &mdash; days for specials dates, discount to range dates
- `roles_access` &mdash; relations between roles and modules access
- `settings` &mdash; CMS basic settings (sitename, emailname, etc.)
- `users` &mdash; Table for users and rol user

### Models

#### Role

The `Role` model has three main attributes:
- `name` &mdash; Unique name for the Role, used for looking up role information in the application layer. For example: "admin", "owner", "employee".
- `display_name` &mdash; Human readable name for the Role. Not necessarily unique and optional. For example: "User Administrator", "Project Owner", "Widget  Co. Employee".
- `description` &mdash; A more detailed explanation of what the Role does. Also optional.

Both `display_name` and `description` are optional; their fields are nullable in the database.

#### Permission

The `Permission` model has the same three attributes as the `Role`:
- `name` &mdash; Unique name for the permission, used for looking up permission information in the application layer. For example: "create-post", "edit-user", "post-payment", "mailing-list-subscribe".
- `display_name` &mdash; Human readable name for the permission. Not necessarily unique and optional. For example "Create Posts", "Edit Users", "Post Payments", "Subscribe to mailing list".
- `description` &mdash; A more detailed explanation of the Permission.

In general, it may be helpful to think of the last two attributes in the form of a sentence: "The permission `display_name` allows a user to `description`."

#### User

This will enable the relation with `Role` and add the following methods `roles()`, `hasRole($name)`, `withRole($name)`, `can($permission)`, and `ability($roles, $permissions, $options)` within your `User` model.

**And you are ready to go.**

##Usage

### Middleware

You can use a middleware to filter routes and route groups by permission or role
```php
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
    Route::get('/', 'AdminController@welcome');
    Route::get('/manage', ['middleware' => ['permission:manage-admins'], 'uses' => 'AdminController@manageAdmins']);
});
```

It is possible to use pipe symbol as *OR* operator:
```php
'middleware' => ['role:admin|root']
```

To emulate *AND* functionality just use multiple instances of middleware
```php
'middleware' => ['role:owner', 'role:writer']
```

For more complex situations use `ability` middleware which accepts 3 parameters: roles, permissions, validate_all
```php
'middleware' => ['ability:admin|owner,create-post|edit-user,true']
```

## License

COgroup CMS is free software distributed under the terms of the MIT license.

## Contribution guidelines

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.  
Pull requests are welcome.
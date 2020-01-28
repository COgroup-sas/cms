<?php

namespace Cogroup\Cms\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CogroupCmsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('settings')->insert([
      [
        'setting'       => 'sitename',
        'defaultvalue'  => 'CMS'
      ],
      [
        'setting'       => 'emailname',
        'defaultvalue'  => 'CMS support'
      ],
      [
        'setting'       => 'emailaddress',
        'defaultvalue'  => 'support@cogroupsas.com'
      ],
      [
        'setting'       => 'timeformat',
        'defaultvalue'  => 'h:i a'
      ],
      [
        'setting'       => 'dateformat',
        'defaultvalue'  => 'Y-m-d'
      ],
      [
        'setting'       => 'sitedescription',
        'defaultvalue'  => 'COgroup CMS'
      ],
      [
        'setting'       => 'sitekeywords',
        'defaultvalue'  => 'COgroup, cms'
      ],
      [
        'setting'       => 'phone',
        'defaultvalue'  => '+00 (0) 000 0000'
      ],
      [
        'setting'       => 'mobile',
        'defaultvalue'  => '+00 000 000 0000'
      ],
      [
        'setting'       => 'address',
        'defaultvalue'  => ''
      ],
      [
        'setting'       => 'favicon',
        'defaultvalue'  => ''
      ],
      [
        'setting'       => 'logo',
        'defaultvalue'  => ''
      ],
      [
        'setting'       => 'socialaccess',
        'defaultvalue'  => '1'
      ]
      [
        'setting'       => 'socialaccessgoogle',
        'defaultvalue'  => '1'
      ]
      [
        'setting'       => 'socialaccessfacebook',
        'defaultvalue'  => '0'
      ]
      [
        'setting'       => 'socialaccesstwitter',
        'defaultvalue'  => '0'
      ]
    ]);

    DB::table('roles')->insert([
      [
        'rolname' => 'Superusuario',
        'description' => 'Super Usuario'
      ],
      [
        'rolname' => 'Administrador',
        'description' => 'Rol para Administradores'
      ]
    ]);

    DB::table('modules')->insert([
      //Administración
      [ 
        'id' => '1', 'moduleslug' => 'settings', 'modulename' => 'Ajustes', 'description' => 'Módulo de Administración de Ajustes generales del sitio', 
        'active' => 'Y', 'url' => (empty(config('cogroupcms.uri')) ? '' : config('cogroupcms.uri')."/").'settings', 'icon' => 'fa fa-cogs', 'parent' => '0', 'order' => '0', 'inmenu' => 'Y', 
        'permissions' => 'view,update'
      ],
      [ 
        'id' => '2', 'moduleslug' => 'roles', 'modulename' => 'Roles', 'description' => 'Módulo de Administración de Roles del sistema', 
        'active' => 'Y', 'url' => (empty(config('cogroupcms.uri')) ? '' : config('cogroupcms.uri')."/").'roles', 'icon' => 'fa fa-user-plus', 'parent' => '0', 'order' => '1', 'inmenu' => 'Y', 
        'permissions' => 'view,create,update'
      ],
      [ 'id' => '3', 'moduleslug' => 'permissions', 'modulename' => 'Permisos', 'description' => 'Módulo de Administración de permisos del sistema', 
        'active' => 'Y', 'url' => (empty(config('cogroupcms.uri')) ? '' : config('cogroupcms.uri')."/").'roles/permissions', 'icon' => 'fa fa-check-circle', 'parent' => '2', 'order' => '0', 'inmenu' => 'N', 
        'permissions' => 'view,update'
      ],
      [ 'id' => '4', 'moduleslug' => 'users', 'modulename' => 'Usuarios', 'description' => 'Módulo de Administración de usuarios del sistema', 
        'active' => 'Y', 'url' => (empty(config('cogroupcms.uri')) ? '' : config('cogroupcms.uri')."/").'users', 'icon' => 'fa fa-users', 'parent' => '0', 'order' => '3', 'inmenu' => 'Y', 
        'permissions' => 'view,create,update'
      ]
    ]);

    DB::table('roles_access')->insert(
      [
        ['roles_id' => '1', 'modules_id' => '1', 'view' => '1', 'create' => '0', 'update' => '1', 'delete' => '0'],
        ['roles_id' => '1', 'modules_id' => '2', 'view' => '1', 'create' => '1', 'update' => '1', 'delete' => '0'],
        ['roles_id' => '1', 'modules_id' => '3', 'view' => '1', 'create' => '0', 'update' => '1', 'delete' => '0'],
        ['roles_id' => '1', 'modules_id' => '4', 'view' => '1', 'create' => '1', 'update' => '1', 'delete' => '0']
      ]
    );

    DB::table('users')->insert(
      [
        'name' => 'Super',
        'lastname' => 'Administrador',
        'email' => 'cms@cogroupsas.com',
        'password' => bcrypt('password'),
        'roles_id' => '1',
        'active' => 'Y',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ]
    );

    DB::table('noworkingdays')->insert(
      [
        //2019
        //Enero
        ['date' => '2019-01-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-01-06', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-01-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-01-13', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-01-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-01-27', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Febrero
        ['date' => '2019-02-03', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-02-10', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-02-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-02-24', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Marzo
        ['date' => '2019-03-03', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-03-10', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-03-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-03-24', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-03-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-03-31', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Abril
        ['date' => '2019-04-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-04-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-04-18', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-04-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-04-21', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-04-28', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Mayo
        ['date' => '2019-05-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-05-05', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-05-12', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-05-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-05-26', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Junio
        ['date' => '2019-06-02', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-06-03', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-06-09', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-06-16', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-06-23', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-06-24', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-06-30', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Julio
        ['date' => '2019-07-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-07-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-07-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-07-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-07-21', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-07-28', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Agosto
        ['date' => '2019-08-04', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-08-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-08-11', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-08-18', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-08-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-08-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Septiembre
        ['date' => '2019-09-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-09-08', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-09-15', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-09-22', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-09-29', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Octubre
        ['date' => '2019-10-06', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-10-13', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-10-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-10-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-10-27', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Noviembre
        ['date' => '2019-11-03', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-11-04', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-11-10', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-11-11', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-11-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-11-24', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Diciembre
        ['date' => '2019-12-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-12-08', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-12-15', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-12-22', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-12-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2019-12-29', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],

        //2020
        //Enero
        ['date' => '2020-01-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-01-05', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-01-06', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-01-12', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-01-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-01-26', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Febrero
        ['date' => '2020-02-02', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-02-09', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-02-16', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-02-23', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Marzo
        ['date' => '2020-03-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-03-08', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-03-15', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-03-22', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-03-23', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-03-29', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Abril
        ['date' => '2020-04-05', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-04-09', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-04-10', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-04-12', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-04-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-04-26', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Mayo
        ['date' => '2020-05-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-05-03', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-05-10', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-05-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-05-24', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-05-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-05-31', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Junio
        ['date' => '2020-06-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-06-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-06-15', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-06-21', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-06-22', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-06-28', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-06-29', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Julio
        ['date' => '2020-07-05', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-07-12', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-07-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-07-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-07-26', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Agosto
        ['date' => '2020-08-02', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-08-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-08-09', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-08-16', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-08-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-08-23', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-08-30', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Septiembre
        ['date' => '2020-09-06', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-09-13', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-09-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-09-27', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Octubre
        ['date' => '2020-10-04', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-10-11', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-10-12', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-10-18', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-10-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Noviembre
        ['date' => '2020-11-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-11-02', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-11-08', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-11-15', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-11-16', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-11-22', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-11-29', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Diciembre
        ['date' => '2020-12-06', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-12-08', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-12-13', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-12-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-12-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2020-12-27', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],

        //2021
        //Enero
        ['date' => '2021-01-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-01-03', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-01-10', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-01-11', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-01-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-01-24', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-01-31', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Febrero
        ['date' => '2021-02-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-02-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-02-21', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-02-28', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Marzo
        ['date' => '2021-03-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-03-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-03-21', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-03-22', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-03-28', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Abril
        ['date' => '2021-04-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-04-02', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-04-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-04-11', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-04-18', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-04-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Mayo
        ['date' => '2021-05-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-05-02', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-05-09', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-05-16', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-05-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-05-23', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-05-30', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Junio
        ['date' => '2021-06-06', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-06-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-06-13', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-06-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-06-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-06-27', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Julio
        ['date' => '2021-07-04', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-07-05', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-07-11', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-07-18', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-07-20', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-07-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Agosto
        ['date' => '2021-08-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-08-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-08-08', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-08-15', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-08-16', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-08-22', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-08-29', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Septiembre
        ['date' => '2021-09-05', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-09-12', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-09-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-09-26', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Octubre
        ['date' => '2021-10-03', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-10-10', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-10-17', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-10-18', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-10-24', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-10-31', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Noviembre
        ['date' => '2021-11-01', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-11-07', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-11-14', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-11-15', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-11-21', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-11-28', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        //Diciembre
        ['date' => '2021-12-05', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-12-08', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-12-12', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-12-19', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-12-25', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
        ['date' => '2021-12-26', 'active' => 'Y', 'created_at' => date('Y-m-d H:i:s')],
      ]
    );
  }
}

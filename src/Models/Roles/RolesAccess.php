<?php

namespace Cogroup\Cms\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use Cogroup\Cms\Models\Modules;
use Illuminate\Support\Facades\Auth;
use Cogroup\Cms\Models\User;

class RolesAccess extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'roles_access';

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = true;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'roles_id', 'modules_id', 'view', 'create', 'update', 'delete', 'created_at', 'updated_at'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'id'
  ];

  public function Rol() {
    return $this->belongsTo('Cogroup\Cms\Models\Roles\Roles', 'rol_id');
  }

  public function modules() {
    return $this->belongsTo('Cogroup\Cms\Models\Modules', 'modules_id');
  }

  public static function registerRol($idrol) {
    $modulesrol = RolesAccess::select('modules_id')->where('roles_id', $idrol)->get();

    $modules = Modules::select('id')
                      ->where('active', 'Y')
                      ->whereNotIn('id', $modulesrol)
                      ->get();

    $modulesRol = array();

    foreach($modules as $key => $module) :
      $modulesRol[] = array(
        'roles_id' => $idrol,
        'modules_id' => $module->id,
      );
    endforeach;

    self::insert($modulesRol);
  }
}
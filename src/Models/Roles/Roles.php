<?php

namespace Cogroup\Cms\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'roles';

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
    'rolname', 'description', 'created_at', 'updated_at'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'id'
  ];

  public function RolAccess() {
    return $this->hasMany('Cogroup\Cms\Models\Roles\RolesAccess', 'roles_id');
  }
}

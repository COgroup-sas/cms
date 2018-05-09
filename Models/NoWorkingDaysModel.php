<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiasNoLaborablesModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'diasnolaborables';

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
    'id', 'fecha', 'active', 'created_at', 'updated_at', 'id_user_create', 'id_user_update'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  ];

  public function userCreated() {
    return $this->belongsTo('App\User', 'id', 'id_user_create');
  }

  public function userUpdated() {
    return $this->belongsTo('App\User', 'id', 'id_user_update');
  }
}

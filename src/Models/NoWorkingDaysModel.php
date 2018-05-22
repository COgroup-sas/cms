<?php

namespace Cogroup\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class DiasNoLaborablesModel extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'noworkingdays';

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
    'id', 'date', 'active', 'created_at', 'updated_at'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  ];

  public function userCreated() {
    return $this->belongsTo('Cogroup\Cms\Models\User', 'id', 'id_user_create');
  }

  public function userUpdated() {
    return $this->belongsTo('Cogroup\Cms\Models\User', 'id', 'id_user_update');
  }
}

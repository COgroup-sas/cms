<?php

namespace Cogroup\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'modules';

  protected $connection = 'mysql';

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
    'id', 'moduleslug', 'modulename', 'description', 'active', 'url', 'icon', 'parent', 'order', 'inmenu', 'permissions'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  ];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['deleted_at'];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
    'id' => 'integer', 
    'modulename' => 'string', 
    'description' => 'string', 
    'active' => 'string', 
    'url' => 'string', 
    'icon' => 'string', 
    'parent' => 'integer', 
    'order' => 'integer', 
    'inmenu' => 'string', 
    'permissions' => 'string'
  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
      
  ];
}

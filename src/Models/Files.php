<?php

namespace Cogroup\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'files';

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
    'originalname', 'diskname', 'extension', 'size', 'mimetype', 'width', 'height', 'ispublic', 'created_at', 
    'updated_at'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'id'
  ];
}

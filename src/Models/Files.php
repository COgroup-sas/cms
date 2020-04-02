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
    'originalname', 'diskname', 'extension', 'size', 'mimetype', 'alt', 'width', 'height', 'ispublic', 'created_at', 
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

  /**
  * The attributes that should be mutated to dates.
  *
  * @var array
  */
  protected $dates = ['created_at', 'updated_at'];

  /**
  * The attributes that should be casted to native types.
  *
  * @var array
  */
  protected $casts = [
    'id' => 'integer',
    'originalname' => 'string',
    'diskname' => 'string', 
    'extension' => 'string',
    'size' => 'integer', 
    'mimetype' => 'string', 
    'alt' => 'string',
    'width' => 'integer',
    'height' => 'integer',
    'ispublic' => 'integer',
    'created_at' => 'string',
    'updated_at' => 'string'
  ];

  /**
   * Get the user's full name.
   *
   * @return string
   */
  public function getUrl()
  {
    return route('getFile', $this->id);
  }

  /**
   * Get the user's full name.
   *
   * @return string
   */
  public function getThumbUrl($width = 240, $height = 360)
  {
    return route('thumb', $this->id, $height, $width);
  }
}

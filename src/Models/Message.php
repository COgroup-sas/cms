<?php

namespace Cogroup\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'messages';

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
    'id', 'from', 'to', 'message', 'read'
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
  protected $dates = [];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
    'id' => 'integer', 
    'from' => 'integer', 
    'to' => 'integer', 
    'message' => 'string',
    'read_at' => 'datetime'
  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
      
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function fromUser()
  {
		return $this->belongsTo("Cogroup\Cms\Models\User", 'from');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function toUser()
  {
		return $this->belongsTo("Cogroup\Cms\Models\User", 'to');
  }

  /**
   * Mark the notification as read.
   *
   * @return void
   */
  public function markAsRead()
  {
    if (is_null($this->read_at)) {
      $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
    }
  }
}

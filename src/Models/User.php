<?php

namespace Cogroup\Cms\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'roles_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
    public function Roles()
    {
        return $this->belongsTo("Cogroup\Cms\Models\Roles\Roles", 'roles_id');
    }
}

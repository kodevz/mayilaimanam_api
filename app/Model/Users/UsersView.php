<?php

namespace App\Model\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersView extends Model
{
    

    protected $table = 'users_view';

    public function modalData() 
    {
        return $this->hasOne('App\User', 'id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }
}

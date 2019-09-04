<?php

namespace App\Model;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    protected $loginNames = ['username', 'email'];

    public function projects()
    {
        return $this->hasMany('App\Model\Project');
    }

    public function messages()
    {
        return $this->hasMany('App\Model\Message');
    }

    public function alerts()
    {
        return $this->hasMany('App\Model\Alert');
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table ='users';
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','telephone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function EmailToken()
    {
        return $this->hasOne('App\EmailToken');
    }

    public function informations()
    {
        return $this->belongsToMany('App\information','users_of_informations','information_id','user_id');
    }

    public function users_of_informations()
    {
        return $this->hasMany('App\users_of_information','user_id');
    }

}

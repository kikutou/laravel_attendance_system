<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = "informations";

    public function users()
    {
        return $this->belongsToMany('App\user','users_of_informations','information_id','user_id');
    }

    public function users_of_informations()
    {
        return $this->hasMany('App\users_of_information','information_id');
    }
}

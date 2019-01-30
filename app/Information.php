<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = "informations";

    public function users()
    {
        return $this->belongsToMany('App\Model\user','users_of_informations','information_id','user_id');
    }
}

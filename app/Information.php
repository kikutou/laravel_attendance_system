<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = "informations";

    public function users_of_informations()
    {
        return $this->hasMany('App\users_of_information','information_id');
    }·
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_of_information extends Model
{
	protected $table='Users_of_informations';

  　public function user()
  　{
    　return $this->belongsTo('App\Model\User','user_id');
  　}

  　public function information()
  　{
    　return $this->belongsTo('App\Model\information','information_id');
  　}
}
	
<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  public function check()
  {
    return $this->hasMany("App\Model\AttendanceRecord\AttendanceRecord", "user_id");
  }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
  public function check()
  {
    return $this->hasMany("App\Model\AttendanceRecord", "user_id");
  }
}

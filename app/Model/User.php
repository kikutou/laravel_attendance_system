<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
  use SoftDeletes;

  public function attendance_record()
  {
    return $this->hasMany('App\Model\AttendanceRecord', 'user_id');
  }
}

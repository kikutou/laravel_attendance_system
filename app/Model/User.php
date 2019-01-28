<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function attendance_record()
    {
      return $this->hasMany("App\Model\AttendanceRecord", "user_id");
    }

}

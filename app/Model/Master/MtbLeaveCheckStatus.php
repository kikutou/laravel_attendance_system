<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class MtbLeaveCheckStatus extends Model
{
  public function attend()
  {
    return $this->hasMany("App\Model\AttendanceRecord", "mtb_leave_check_status_id");
  }
}

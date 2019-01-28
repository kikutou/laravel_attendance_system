<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class MtbLeaveCheckStatuse extends Model
{
  const APPROVAL_PENDING = 1;
  const APPROVAL = 2;
  const REFUSE = 3;
  protected $table = "mtb_leave_check_statuses";

  public function check()
  {
    return $this->hasMany("App\Model\AttendanceRecords\AttendanceRecord", "mtb_leave_check_status_id");
  }
}

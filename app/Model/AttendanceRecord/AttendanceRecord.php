<?php

namespace App\Model\AttendanceRecord;

use Illuminate\Database\Eloquent\Model;


class AttendanceRecord extends Model
{
    protected $table = "attendance_records";
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'attendace_date'];

    public function check()
    {
      return $this->belongsTo("App\Model\Master\MtbLeaveCheckStatuse", "mtb_leave_check_status_id");
    }
    public function user()
    {
      return $this->belongsTo("App\Model\User\User", "user_id");
    }

}

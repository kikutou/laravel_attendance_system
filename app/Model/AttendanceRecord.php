<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceRecord extends Model
{
    protected $table = "attendance_records";

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'attendace_date'];

    use SoftDeletes;

    public function users()
      {
        return $this->belongsTo("App\Model\User", "user_id");
      }

    public function mtb_leave_check_statuses()
    {
      return $this->belongsTo("App\Model\Master\MtbLeaveCheckStatus", "mtb_leave_check_status_id");
    }

}

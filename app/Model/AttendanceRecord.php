<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceRecord extends Model
{
  protected $table = 'attendance_records';
  protected $dates = ['deleted_at', 'created_at', 'updated_at', 'attendance_date']; //'start_time', 'end_time', 'leave_start_time', 'leave_end_time', 'leave_applicate_time', 'leave_check_time'

  use SoftDeletes;

  public function users()
  {
    return $this->belongsTo('App\Model\User', 'user_id');
  }

  public function mtb_leave_check_status()
  {
    return $this->belongsTo('App\Model\Master\MtbLeaveCheckStatus', 'mtb_leave_check_status_id');
  }

}

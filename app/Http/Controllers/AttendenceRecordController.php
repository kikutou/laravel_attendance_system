<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User\User;
use App\Model\AttendanceRecord\AttendanceRecord;
use App\Model\Master\MtbLeaveCheckStatuse;
use Carbon\Carbon;

class AttendenceRecordController extends Controller
{
    public function show_index(Request $request)
    {
      return view('user_a_week');
    }

    public function get_all(Request $request)
    {
      $attendance_records = AttendanceRecord::all();
      return view('user_a_week',['attendance_records'=>$attendance_records]);
    }
}

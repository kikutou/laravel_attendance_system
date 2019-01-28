<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;

class CommandController extends Controller
{
    public function check()
    {
      $attendance_records = AttendanceRecord::all();
      foreach($attendance_records as $key => $record){
        if($record->user_id == $attendance_records[$key+1]->user_id &&
           $record->attendance_date == $attendance_records[$key+1]->attendance_date){

        }
     }
  }
}

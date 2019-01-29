<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;

class CommandController extends Controller
{
  /**
   *
   *重複レコードの検出。
   *
   */
  public function check()
  {
    $records = AttendanceRecord::all();
    $i = 0;
    $temp_arr = array();
    foreach($records as $record){
      $double_records = AttendanceRecord::where('user_id',$record->user_id)
                                        ->where('attendance_date',$record->attendance_date)
                                        ->get();
      if(count($double_records) >= 2){
        foreach($double_records as $double_record){
          if(!in_array($double_record->id,$temp_arr)) echo $double_record->id." ";
          $temp_arr[$i] = $double_record->id;
          $i++;
        }
      }
    }
}
}

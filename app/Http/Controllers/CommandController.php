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
    $temp_arr = [];
    $double_records = [];
    foreach($records as $record){
      $double_records = AttendanceRecord::where('user_id',$record->user_id)->where('attendance_date',$record->attendance_date)->get();

      if (count($double_records) >= 2) {
        foreach ($double_records as $double_record) {
          if(in_array($double_record, $temp_arr)){
            continue;
          } else {
            $temp_arr[] = $double_record;
          }
        }
      } else {
        continue;
      }
    }

    if ($temp_arr)
    {
      foreach ($temp_arr as $temp_one) {
        echo $temp_one->id . '(' . $temp_one->attendance_date->format('Y-m-d') . ' ' . $temp_one->user_id  . ')' . "\n";
      }
    } else {
      echo 'ok';
    }
  }
}

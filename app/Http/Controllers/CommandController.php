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
        for($j = 0; $j < count($double_records); $j++){
          if(!in_array($double_records[$j]->id,$temp_arr)){
            echo $double_records[$j]->id." ";
           if($j == count($double_records)-1) echo "\n";
         }
          $temp_arr[$i] = $double_records[$j]->id;
          $i++;
        }
      }
    }
}
}

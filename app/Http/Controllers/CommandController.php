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
      $count = $records->count();
      $temp_count = 0;

      for($i = 0; $i < $count-1; $i++){
        $temp_count = 0;
        for($j = $i+1;$j < $count;$j++){
          if($records[$i]->user_id == $records[$j]->user_id &&
             $records[$i]->attendance_date == $records[$j]->attendance_date){
               $temp_count++;
               if($temp_count == 1) echo $records[$i]->id.",".$records[$j]->id;
               else echo ",".$records[$j]->id;
          }
       }
       if($temp_count >= 1) echo "\n";
     }
     if($temp_count == 0){
       echo "ok";
     }
  }
}

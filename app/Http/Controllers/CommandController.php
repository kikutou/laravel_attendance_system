<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;

class CommandController extends Controller
{
  /**
   *
   *AttendanceRecordの重複レコードの検出。
   *
   */
  public function check()
  {
    $temp_arr = array();//重複レコードのidを保存する一時的なarrayを定義。
    $i = 0;//上記のarrayのindexを定義。
    $count = 0;//重複レコードarrayの出現回数。
    $records = AttendanceRecord::whereNotNull('attendance_date')->get();//出席記録のあるレコードをすべて抽出。
    foreach($records as $record){
      $double_records = AttendanceRecord::where('user_id',$record->user_id)
                                        ->where('attendance_date',$record->attendance_date)
                                        ->get(); //各レコードに重複あるかチェックする。
      if(count($double_records) >= 2){  //もし$double_recordsのelementが2以上である場合、レコードが重複することになる。
        $count++;//重複判定が発生するたびに、出現回数が+1される。
        for($j = 0; $j < count($double_records); $j++){ //重複レコードのidを出力する。
          if(!in_array($double_records[$j]->id,$temp_arr)) //既に出力されたidが再び出力されないよう判定を行う。
           echo $double_records[$j]->id.($j != count($double_records)-1 ? ",":"\n"); //重複レコードのidを','で、異なるarrayを'\n'で区切り出力する。
          $temp_arr[$i] = $double_records[$j]->id;//既に出力されたidを記録するarray。
          $i++;//indexのincrement;
        }
      }
    }
    if($count == 0 ) echo "ok";//重複レコードがない場合、'ok'が出力される。
  }
}

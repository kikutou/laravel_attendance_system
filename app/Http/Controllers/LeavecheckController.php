<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use App\Model\Master\MtbLeaveCheckStatus;
use App\Model\User;

class LeavecheckController extends Controller
{
  public function check(Request $request, $status = null)
  {
    // 一览页面
    if ($request->isMethod('get')) {
        $statusArr = [
            'approval_pending' => MtbLeaveCheckStatus::APPROVAL_PENDING,
            'approval' => MtbLeaveCheckStatus::APPROVAL,
            'refuse' => MtbLeaveCheckStatus::REFUSE
        ];

        $status = $status ?? 'all';
        $attendancerecords = ($status == 'all')
            ? AttendanceRecord::all()
            : AttendanceRecord::where("mtb_leave_check_status_id", $statusArr[$status])->get();

        return view(
            "admin.leave_check",
            [
                "current_page" => $status,
                "attendancerecords" => $attendancerecords,
                "status" => $status
            ]
        );
    }
    // 审核操作
    if ($request->isMethod('post')) {
        // $request->act 是前台post过来的参数 值为 agree: 同意；disagree：不同意
        $Act = ['agree' => MtbLeaveCheckStatus::APPROVAL, 'disagree' => MtbLeaveCheckStatus::REFUSE];
        if ($request->act && $request->mtb_leave_check_status_id && array_key_exists($request->act, $Act)) {
            $leave = AttendanceRecord::where("mtb_leave_check_status_id", $request->mtb_leave_check_status_id)->first();
            if ($leave->mtb_leave_check_status_id == MtbLeaveCheckStatus::APPROVAL_PENDING){
                $leave->mtb_leave_check_status_id = $Act[$request->act];
                $leave->save();
                echo $request->act == 'agree' ? '承認しました' : '断りました';
            }
        }
    }
  }
  //之前的写法
    // if($request->isMethod("POST"))
    // {
    //   if($request->yes){
    //   $leave = AttendanceRecord::where("mtb_leave_check_status_id", $request->mtb_leave_check_status_id)->first();
    //   if($leave->mtb_leave_check_status_id == MtbLeaveCheckStatuse::APPROVAL_PENDING){
    //     $leave->mtb_leave_check_status_id = MtbLeaveCheckStatuse::APPROVAL;
    //     $leave->save();
    //     echo "承認しました";
    //     }
    //   }elseif($request->no){
    //   $leave = AttendanceRecord::where("mtb_leave_check_status_id", $request->mtb_leave_check_status_id)->first();
    //   if($leave->mtb_leave_check_status_id == MtbLeaveCheckStatuse::APPROVAL_PENDING){
    //     $leave->mtb_leave_check_status_id = MtbLeaveCheckStatuse::REFUSE;
    //     $leave->save();
    //     echo "断りました";
    //     }
    //   }
    // }
    // $attendancerecords = null;
    // $current_page = "all";
    // if(!$status) {
    //   $attendancerecords = AttendanceRecord::whereIn("mtb_leave_check_status_id", [MtbLeaveCheckStatuse::APPROVAL_PENDING,MtbLeaveCheckStatuse::APPROVAL, MtbLeaveCheckStatuse::REFUSE]);
    // } elseif($status == "approval_pending") {
    //   $attendancerecords = AttendanceRecord::where("mtb_leave_check_status_id", MtbLeaveCheckStatuse::APPROVAL_PENDING);
    //   $current_page = "approval_pending";
    // } elseif($status == "approval") {
    //   $attendancerecords = AttendanceRecord::where("mtb_leave_check_status_id", MtbLeaveCheckStatuse::APPROVAL);
    //   $current_page = "approval";
    // } elseif($status == "refuse") {
    //   $attendancerecords = AttendanceRecord::where("mtb_leave_check_status_id", MtbLeaveCheckStatuse::REFUSE);
    //   $current_page = "refuse";
    // }
    //   $attendancerecords = $attendancerecords->get();
    //
    // return view("admin.leave_check", ["current_page" => $current_page,"attendancerecords" => $attendancerecords, "status" => $status]);
}

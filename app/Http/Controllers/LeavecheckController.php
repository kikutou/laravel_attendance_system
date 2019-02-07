<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use App\Model\Master\MtbLeaveCheckStatus;
use App\User;
use Carbon\Carbon;

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
            ? AttendanceRecord::whereNotNull('mtb_leave_check_status_id')->orderBy("attendance_date",'desc')->get()
            : AttendanceRecord::where("mtb_leave_check_status_id", $statusArr[$status])
              ->orderBy("attendance_date",'desc')
              ->get();

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
            $leave = AttendanceRecord::where("id", $request->id)->first();
            if ($leave->mtb_leave_check_status_id == MtbLeaveCheckStatus::APPROVAL_PENDING){
                $leave->mtb_leave_check_status_id = $Act[$request->act];
                $leave->leave_check_time = Carbon::now();
                $leave->updated_at = Carbon::now();
                $leave->save();

                if($request->act == 'agree'){
                  return redirect()->back()->with(["message" => '承認しました']);
                }
                 return redirect()->back()->with(["message" => "断りました"]);
            }
        }
    }
  }

}

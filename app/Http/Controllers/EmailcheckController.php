<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use App\Model\Master\MtbLeaveCheckStatus;
use App\Model\User;

class EmailcheckController extends Controller
{
    public function show_mail(Request $request)
    {
      $users = User::query()->where('email_verified_at', null)
        ->get();
        return view('admin.email_check',['users' => $users]);
    }

    public function check_mail(Request $request)
    {
      $user = User::find($request->id);
      $user->email_verified_at = $user->updated_at;
      $user->save();
      echo "操作成功しました";
    }
}

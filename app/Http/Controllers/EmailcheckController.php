<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AttendanceRecord;
use App\Model\Master\MtbLeaveCheckStatus;
use App\Model\User;
use Carbon\Carbon;

class EmailcheckController extends Controller
{
    public function show_mail(Request $request)
    {
      $users = User::where('email_verified_at', null)
        ->get();
        return view('admin.email_check',['users' => $users]);
    }

    public function check_mail(Request $request)
    {
      $user = User::find($request->id);
      if($user->email_verified_at){
        return redirect()->back()->with(["message" => "該当会員はすでに認証されました。"]);
      };
      if($request->delete && $user->email_verified_at == null){
        $request->confirmOrNOt = 'no';
        $user->delete();
        return redirect()->back()->with(["message" => "削除成功"]);
      }
      if($request->confirmOrNOt == 'yes' && $user->email_verified_at == null){
        $user->email_verified_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();
        return redirect()->back()->with(["message" => "認証成功"]);
      }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailToken;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\AttendanceRecord;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      $today = Carbon::now();
      $login_user = Auth::user();
      $user = User::where('id', $login_user->id)->first();
      $att = AttendanceRecord::where('user_id',$user->id)
        ->where('attendance_date', '<=' , Carbon::today()->format('Y-m-d'))
        ->where('attendance_date', '>=' , Carbon::now()->subMonth(1)->format('Y-m-d'))
        ->get();
        // dd(Carbon::now()->subMonth(1)->addDays(1)->format('Y-m-d'));
        // dd($att->toArray());
        // dd(Carbon::now()->subMonth(1)->subDays(1)->format('Y-m-d'));
        // dd($att->toArray());
        // dd(Carbon::today()->format('m-d'));
        // dd(Carbon::now()->subMonth(1)->format('m-d'));
      //  dd($att['0']['start_time']);
      //本月迟到次数
      $late = AttendanceRecord::where('reason')
        ->where('attendance_date', '>=' , Carbon::now()->firstOfMonth()->format('Y-m-d'))
        ->where('attendance_date', '<=' , Carbon::today()->format('Y-m-d'))
        ->get()
        ->count();
      //本月请假次数
      $leave = AttendanceRecord::where('leave_reason')
        ->where('attendance_date', '>=' , Carbon::now()->firstOfMonth()->format('Y-m-d'))
        ->where('attendance_date', '<=' , Carbon::today()->format('Y-m-d'))
        ->get()
        ->count();

      if($user->email_verified_at == null){
          return redirect('/verified')->with('warning', "管理員に
              承認されていませんので、ログインできません。");
      }else{
          return view('home', ['today' => $today, 'late' => $late, 'leave' => $leave,'atts' => $att])->with('message', "ログインできました。");
      }

    }
}

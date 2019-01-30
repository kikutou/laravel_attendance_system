<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EmailToken;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\User;



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
      $today = Carbon::now()->format('Y-m-d');
      $login_user = Auth::user();
      $user = User::where('id', $login_user->id)->first();
      $late = user::where('reason',ture)
        ->where('attendance_date', '>=' , Carbon::now()->firstOfMonth()->format('Y-m-d'))
        ->where('attendance_date', '<=' , Carbon::today()->format('Y-m-d'))
        ->get()
        ->count();
      $leave = User::where('leave_reason',ture)
        ->where('attendance_date', '>=' , Carbon::now()->firstOfMonth()->format('Y-m-d'))
        ->where('attendance_date', '<=' , Carbon::today()->format('Y-m-d'))
        ->get()
        ->count();

      if($user->email_verified_at == null){
          return redirect('/verified')->with('warning', "管理員に
              承認されていませんので、ログインできません。");
      }else{
          return view('home',['today' => $today, 'late' => $late, 'leave' => $leave])->with('message', "ログインできました。");
      }

    }
}

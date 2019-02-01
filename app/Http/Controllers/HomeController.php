<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailToken;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\AttendanceRecord;
use App\Model\Users_of_information;
use App\Model\Information;

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
    public function info()
    {
        $login_user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $users_of_infors = Users_of_information::where('user_id',$login_user->id)
            ->get();
        $infors = array();
        if(isset($users_of_infors)){
            foreach ($users_of_infors as  $users_of_infor) {
                $infors[] = Information::where('id',$users_of_infor->information_id)
                ->where('show_date','<=',$today)
                ->first();
            }
        }

        //$infors按show_date倒序
        $oderby_infors = array();
        while(count($infors) > 0) {
            $no = null;
            $max_show_date = 0;
            foreach ($infors as $key => $infor) {
                if($infor->show_date >= $max_show_date) {
                    $no = $key;
                    $max_show_date = $infor->show_date;
                }
            }
            $oderby_infors[] = $infors[$no];
            unset($infors[$no]);
        }

        return view('info',[
            "oderby_infors" => $oderby_infors
        ]);
    }


    public function readinfo(Request $request,$id)
    {
        //update read_at(成已读)
        $login_user = Auth::user();
        if ($request->isMethod("get")){
            $read_infor = Users_of_information::where('information_id',$id)
                ->where('user_id',$login_user->id)
                ->first();
            $read_infor->read_at = Carbon::now();
            $read_infor->save();
            return redirect(route('get_info'));
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\EmailToken;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\Users_of_information;
use App\Information;


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
    public function index()
    {
        $login_user = Auth::user();
        $user = User::where('id', $login_user->id)->first();
        if($user->email_verified_at == null){
            return redirect('/verified')->with('warning', "管理員に
                承認されていませんので、ログインできません。");
        }else{
            return view('home')->with('message', "ログインできました。");
        }
    }

//在主页显示信息栏 jiang
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

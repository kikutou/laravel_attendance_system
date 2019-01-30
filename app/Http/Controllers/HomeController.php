<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EmailToken;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



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
}

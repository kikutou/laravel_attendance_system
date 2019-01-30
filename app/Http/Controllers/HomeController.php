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
        return view('home');
    }

    public function emailtoken($token)
    {
        
        $emailtoken = EmailToken::where('token', $token)->first();
        if(isset($emailtoken)){
            $user = $emailtoken->user;
            if($user->email_verified_at == null) {
                $user->email_verified_at = Carbon::now();
                $user->update();
                $message = "メールの承認をもらいました。登録できました。";
            }else{
                $message = "登録できました。";
            }
        }else{
            return redirect('/verified')->with('warning', "メールを承認されていません。");
        }
            return redirect('/home')->with('message', $message);
    }
}

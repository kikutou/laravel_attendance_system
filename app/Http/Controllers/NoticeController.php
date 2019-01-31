<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function create_notice(Request $request)
    {
      return view('create_notice');
    }

    public function store_notice(Request $request)
    {
      
    }
}

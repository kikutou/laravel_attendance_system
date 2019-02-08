@extends('layouts.app')
@section('title','ホーム')
@section('content')

    <style>
        main div.container {
            margin-bottom: 20px;
        }
        .td{
          display: table-cell;
          border: 1px solid #e0e0e0;
          vertical-align:middle;
          text-align: center;
        }
    </style>
    @if(!Auth::user()->admin_flg)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @include("sub_view.info_card", ["infos" => Auth::user()->get_all_unread_infos()])
                </div>
            </div>
        </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">名前:{{ Auth::user()->name }}</div>
                    <div class="card-body">
                      <ul>
                        <li class="list-group-item">日付&nbsp:&nbsp{{ $today->format('Y年m月d日')}}</li>
                        <li class="list-group-item">今月の遅刻回数&nbsp:&nbsp{{$late}}</li>
                        <li class="list-group-item">今月の欠勤回数&nbsp:&nbsp{{$leave}}</li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('sub_view.user_attendance_card',
                  [
                    'days' => $days,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                  ])
            </div>
        </div>
    </div>
    @endif


@endsection

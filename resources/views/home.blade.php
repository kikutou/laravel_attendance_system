@extends('layouts.app')

@section('content')

    <style>
        main div.container {
            margin-bottom: 20px;
        }
        span.person-info-title {
            font-weight: bolder;
            padding-right: 15px;
            margin-right: 15px;
        }
        li.list-group-item {
            border: none;
        }
    </style>

    <div class="container">
        @if(Session::has('one_message'))
          <div style="width:500px;margin:0 auto">
            <h5>{{ Session::get('one_message')}}</h5>
          </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">お知らせ</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">免费域名注册</li>
                            <li class="list-group-item">免费 Window 空间托管</li>
                            <li class="list-group-item">图像的数量</li>
                            <li class="list-group-item">
                                <span class="badge">新</span>
                                24*7 支持
                            </li>
                            <li class="list-group-item">每年更新成本</li>
                            <li class="list-group-item">
                                <span class="badge">新</span>
                                折扣优惠
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">個人情報</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><span class="person-info-title">名前</span>{{ Auth::user()->name }}</li>
                            <li class="list-group-item"><span class="person-info-title">メール</span>{{ Auth::user()->email }}</li>
                            <li class="list-group-item"><span class="person-info-title">電話番号</span>{{ Auth::user()->telephone_number }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

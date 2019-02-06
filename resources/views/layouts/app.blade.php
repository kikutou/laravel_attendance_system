<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>@yield('title')</title>

      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}"></script>
      <!-- <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script> -->



      <!-- Fonts -->
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">


      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">


      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="/resources/demos/style.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="https://code.highcharts.com/highcharts.js"></script>




  </head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    勤怠管理システム
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            </li>
                            @if (Route::has('register'))
                              <li class="nav-item">
                                  <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                              </li>
                            @endif
                        @else
                            @if(!Auth::user()->admin_flg)
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}&nbspさん <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('begin_finish_view') }}">{{ __('勤怠管理') }}</a>
                            </li>

                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('get_leave_request') }}">{{ __('休暇申込') }}</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('get_user_all') }}">{{ __('出勤状態') }}</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('get_info') }}">{{ __('お知らせ') }}</a>
                            </li>
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    admin&nbspさん <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('get_user_mail') }}">{{ __('会員認証') }}</a>
                            </li>

                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('get_check') }}">{{ __('休暇認証') }}</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('get_adminchart') }}">{{ __('遅刻照会') }}</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('get_all_info') }}">{{ __('通知関連') }}</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('get_user_find') }}">{{ __('勤怠検索') }}</a>
                            </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <style>
                div.alert {
                    text-align: center;
                }
            </style>
            @if(Session::has('message'))
              <div class="alert alert-success">{{Session::get('message')}}</div>
            @endif

            @if(Session::has('error'))
              <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif

            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                 <div>{{ $error }}</div>
                @endforeach
              </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>

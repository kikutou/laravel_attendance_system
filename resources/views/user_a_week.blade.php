@extends("layouts.app")
@section('title','出席状態')
@section("content")
  <link href="{{ asset('/css/tao.css') }}" rel="stylesheet">
    <h3>一週間の出席表</h3>
      @include("sub_view.attendance_info_table", ["user" => Auth::user(), "days" => 7 , "thisday" => null])
    {{--<div class="row">--}}
      {{--<div class="col-sm text-center">--}}
        {{--<a href="{{ route('get_create_csv') }}">本月の出席状況を確認しましたか？</a>--}}
      {{--</div>--}}
    {{--</div>--}}
@endsection

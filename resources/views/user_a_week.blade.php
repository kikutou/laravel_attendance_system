@extends("layouts.app")
@section('title','出勤状態')
@section("content")
  <link href="{{ asset('/css/tao.css') }}" rel="stylesheet">
    <h3>一週間の勤怠表</h3>
      @include("sub_view.attendance_info_table", ["user" => Auth::user()])
    <div class="row">
      <div class="col-sm text-center">
        <a href="{{ route('get_create_csv') }}">本月の勤怠状況を確認しましたか？</a>
      </div>
    </div>
@endsection

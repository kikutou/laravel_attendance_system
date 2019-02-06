aa@extends('layouts.app')
@section("title","お知らせ")
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @include("sub_view.info_card", ["infos" => $infos])
        </div>
    </div>
</div>
@endsection

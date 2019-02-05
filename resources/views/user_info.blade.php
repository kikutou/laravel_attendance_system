@extends('layouts.app')
@section('title','お知らせ')
@section('content')
<style>
.list-group-item:hover{
  z-index: auto;
}
.inline{
  display:inline-block;
}
.inline_split{
  width: 25%;
  height:60px;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">お知らせ一覧</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td class="list-group-item inline inline_split">公開日付</td>
                        <td class="list-group-item inline inline_split">タイトル</td>
                        <td class="list-group-item inline inline_split">詳細</td>
                        <td class="list-group-item inline inline_split">閲覧状態</td>
                    </tr>
                    @foreach($orderby_infors as $one_pivot)
                      @php $carbon = new \Carbon\Carbon($one_pivot->information->show_date) @endphp
                        @continue($carbon->isFuture())
                      <tr>
                          <td class="list-group-item inline inline_split">{{$one_pivot->information->show_date}}</td>
                          <td class="list-group-item inline inline_split">{{$one_pivot->information->title}}</td>
                          <td class="list-group-item inline inline_split">
                              <button type="button" class="btn btn-primary"data-toggle="modal" data-target="#myModal_{{$one_pivot->id}}">詳細
                              </button>
                              <div class="modal fade" id="myModal_{{$one_pivot->id}}">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 id="myModalLabel">{{ $one_pivot->information->title }}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <span style="float:left">{{ $one_pivot->information->comment }}<span></li>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              @if(!$one_pivot->read_at)
                                  <td class="list-group-item inline inline_split"><a href="{{route('get_readinfo', ['id'=>$one_pivot->id])}}"><button type="button" class="btn btn-primary">未読</button></a></td>
                              @else
                                  <td class="list-group-item inline inline_split"><p>既読</p></td>
                              @endif
                     </tr>
                   @endforeach
                </table>
            </div>
         </div>
      </div>
    </div>
</div>
@endsection

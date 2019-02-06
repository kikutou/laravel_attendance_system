@extends('layouts.app')
@section("title","お知らせ")
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
.td{
  display: table-cell;
  border: 1px solid #e0e0e0;
  vertical-align:middle;
  text-align: center;
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
                        <td class="td">公開日付</td>
                        <td class="td">タイトル</td>
                        <td class="td">詳細</td>
                        <td class="td">閲覧状態</td>
                    </tr>
                    @foreach($orderby_infors as $one_pivot)
                      @php $carbon = new \Carbon\Carbon($one_pivot->information->show_date) @endphp
                        @continue($carbon->isFuture())
                      <tr>
                          <td class="td">{{$one_pivot->information->show_date}}</td>
                          <td class="td">{{$one_pivot->information->title}}</td>
                          <td class="td">
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
                                              <span style="float:left">{!! nl2br(e($one_pivot->information->comment)) !!}<span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              @if(!$one_pivot->read_at)
                                  <td class="td"><a href="{{route('get_readinfo', ['id'=>$one_pivot->id])}}"><button type="button" class="btn btn-primary">未読</button></a></td>
                              @else
                                  <td class="td"><p>既読</p></td>
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

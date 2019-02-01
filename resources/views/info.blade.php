@extends('layouts.app')

@section('content')
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">お知らせ一覧</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>公開日付</th>
                            <th>タイトル</th>
                            <th>コメント</th>
                            <th>閲覧状態</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderby_infors as $one_pivot)
                        <tr>
                            <td>{{$one_pivot->information->show_date}}</td>
                            <td>{{$one_pivot->information->title}}</td>
                            <td>
                                <button type="button" class="btn btn-primary"data-toggle="modal" data-target="#myModal_{{$one_pivot->id}}">コメント
                                </button>
                                <div class="modal fade" id="myModal_{{$one_pivot->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 id="myModalLabel">コメント</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{$one_pivot->information->comment}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!$one_pivot->read_at)
                                    <td><a href="{{route('get_readinfo', ['id'=>$one_pivot->id])}}"><button type="button" class="btn btn-primary">未読</button></a></td>
                                @else
                                    <td><p class="btn-group btn-group-xs">既読</p></td>
                                @endif
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
         </div>
      </div>
    </div>
</div>
@endsection

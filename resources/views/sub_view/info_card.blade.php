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
@if($infos)
<div class="card">
    <div class="card-header">お知らせ一覧</div>
    <div class="card-body">
        <table class="table">
            <tr class="bg-light">
                <td class="td">公開日付</td>
                <td class="td">タイトル</td>
                <td class="td">閲覧状態</td>
            </tr>
            @foreach($infos as $info)
              <tr>
                <td class="td">{{$info->show_date->format("Y年m月d日")}}</td>
                <td class="td">
                    <a href="#myModal_{{$info->id}}" data-toggle="modal" data-target="#myModal_{{$info->id}}">{{$info->title}}</a>
                    <div class="modal fade" id="myModal_{{$info->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 id="myModalLabel">{{ $info->title }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <span style="float:left">{!! nl2br(e($info->comment)) !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                @if(!$info->is_read(Auth::user()))
                  <td class="td"><a href="{{route('get_readinfo', ['id'=>$info->get_pivot_id(Auth::user())])}}"><button type="button" class="btn btn-primary">未読</button></a></td>
                @else
                  <td class="td"><p>既読</p></td>
                @endif
              </tr>
            @endforeach
        </table>
    </div>
</div>
@endif

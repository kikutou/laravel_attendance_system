@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">Informations</div>
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
                        @for($i=0; $i< count($oderby_infors); $i++)
                        <tr>
                            <td>{{$oderby_infors[$i]->show_date}}</td>
                            <td>{{$oderby_infors[$i]->title}}</td>
                            <td>
                                <button type="button"  class="btn-group btn-group-xs"data-toggle="modal" data-target="#myModal_{{$oderby_infors[$i]->id}}">コメント
                                </button>
                                <div class="modal fade" id="myModal_{{$oderby_infors[$i]->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 id="myModalLabel">コメント</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                                </button> 
                                            </div>
                                            <div class="modal-body">
                                                {{$oderby_infors[$i]->comment}}     
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @foreach($oderby_infors[$i]->users_of_informations as $oderby_infors[$i]->users_of_information)
                                @if(!$oderby_infors[$i]->users_of_information->read_at)
                                    <td><a href="{{route('get_readinfo', ['id'=>$oderby_infors[$i]->id])}}"><button type="button" class="btn-group btn-group-xs">未読</button></a></td>
                                @else
                                    <td><p class="btn-group btn-group-xs">既読</p></td>   
                                @endif
                            @endforeach
                        @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
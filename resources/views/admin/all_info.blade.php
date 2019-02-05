@extends('layouts.app')
@section('content')
<style>
 .list-group-item:hover{
    z-index: auto;
   }
 .div-left{
    width:300px;
    float:left
 }
 .inline{
    display:inline-block;
    width: 100%
 }
 .inline_first{
    width:60%;
 }
 .inline_second{
    width:20%;
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
                <div class="card-header">
                  <span>お知らせ一覧</span>
                  <span style="float:right"><a href="{{ route('get_create_notice') }}" style="text-decoration:none">お知らせの新規作成</a></span>
                </div>
                <div class="card-body">
                   <table class="table">
                     <thead>
                       <tr>
                         <th class="inline_first td">タイトル</th>
                         <th class="inline_second td">公開日時</th>
                         <th class="td">作成日時</th>
                       </tr>
                     </thead>
                     <tbody>
                       @foreach($all_infos as $one_info)
                        <tr style="text-align:center">
                          <td class="td">
                            <!-- メインモーダル -->
                            <a href="#myModal{{ $one_info->id }}" data-toggle="modal" data-target="#myModal{{ $one_info->id }}">
                              {{ $one_info->title }}
                            </a>
                            <div div class="modal fade" id="myModal{{ $one_info->id }}">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('post_updated_info') }}" method="post">
                                      @csrf
                                    <div class="modal-header">
                                      <input type="hidden" name="old_title" value="{{ $one_info->title }}">
                                      <h4 id="title{{ $one_info->id }}" class="modal-title">{{ $one_info->title }}</h4>
                                      <button id="subClose{{ $one_info->id }}" type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body" style="height:auto">
                                      <input id="old_content{{ $one_info->id }}" type="hidden" name="old_content" value="{{ nl2br($one_info->comment) }}"></input>
                                      <p id="content{{ $one_info->id }}"></p>
                                    </div>
                                    <div class="modal-body">
                                      <input type="hidden" name="info_id" value="{{ $one_info->id }}">
                                      <span id="update{{ $one_info->id }}"></span>
                                    </form>
                                    @php $carbon = new \Carbon\Carbon($one_info->show_date); @endphp
                                      @if(!$carbon->lt(\Carbon\Carbon::today()))
                                        <button type="button" id="amend{{ $one_info->id }}" class="btn btn-primary" style="float:right;margin-top:15px">修正</button>
                                      @endif
                                    <script>
                                    $(function(){
                                      $('#content{{ $one_info->id }}').html('<p id="content{{ $one_info->id }}" style="text-align:left">' + $('#old_content{{ $one_info->id }}').val() + '</p>');
                                    })
                                     $(function(){
                                       $('#amend{{ $one_info->id }}').click(function(){
                                         $('#update{{ $one_info->id }}').html('<input id="update{{ $one_info->id }}" type="submit" class="btn btn-primary" value="更新" style="float:right;margin-top:15px;margin-left:20px">');
                                         $('#title{{ $one_info->id }}').html('<textarea id="title{{ $one_info->id }}" name="new_title" class="form-control" rows="1">' + $('#title{{ $one_info->id }}').text() + '</textarea>');
                                         $('#content{{ $one_info->id }}').html('<textarea id="content{{ $one_info->id }}" name="new_content" class="form-control">' + $('#content{{ $one_info->id }}').text() +'</textarea>');
                                       });
                                     })
                                    </script>
                                  </div>
                                  <div class="modal-footer">
                                    <div class="div-left">既読人数&nbsp:
                                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#innerModal{{ $one_info->id }}">
                                          @php $read_users = $one_info->users_of_informations()->whereNotNull('read_at')->get(); @endphp
                                            {{ count($read_users) }}
                                        </button>人
                                    </div>
                                    <button id="close{{ $one_info->id }}" type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <script>
                                     $(function(){
                                       $('#subClose{{ $one_info->id }},#close{{ $one_info->id }}').click(function(){
                                         $('#update{{ $one_info->id }}').html('<span id="update{{ $one_info->id }}"></span>');
                                         $('#title{{ $one_info->id }}').html('<h4 id="title{{ $one_info->id }}" class="modal-title">' + $('#title{{ $one_info->id }}').text() + '</h4>');
                                         $('#content{{ $one_info->id }}').html('<p id="content{{ $one_info->id }}" style="text-align:left">' + $('#old_content{{ $one_info->id }}').val() + '</p>');
                                       });
                                     })
                                   </script>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- インナーモーダル -->
                            <div class="modal fade" id="innerModal{{ $one_info->id }}">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">既読人数一覧</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                  </div>
                                  <div class="modal-body">
                                    @foreach($read_users as $read_user)
                                      <li class="list-group-item">
                                        {{ $read_user->user->name }}
                                      </li>
                                    @endforeach
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- ここまで -->
                          </td>
                          <!-- ここまで -->
                        <td class="td">{{ $one_info->show_date }}</td>
                        <td class="td">{{ $one_info->created_at }}</td>
                       </tr>
                       @endforeach
                     </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

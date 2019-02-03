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
    width:80%;
 }
 .inline_second{
    width:20%;
 }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">お知らせ一覧</div>
                <div class="card-body">
                   <table class="table">
                     <tr style="text-align:center">
                       <td class="list-group-item inline inline_first">タイトル</td>
                       <td class="list-group-item inline inline_second">作成日時</td>
                     </tr>
                     @foreach($all_infos as $one_info)
                      <tr style="text-align:center">
                        <td class="list-group-item inline inline_first" style="height:70px">
                          <!-- ここからモーダル -->
                          <button type="button" class="btn btn-link active" data-toggle="modal" data-target="#myModal{{ $one_info->id }}">
                            {{ $one_info->title }}
                          </button>
                          <div div class="modal fade" id="myModal{{ $one_info->id }}">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <form action="{{ route('post_updated_info') }}" method="post">
                                    @csrf
                                  <div class="modal-header">
                                    <input type="hidden" name="old_title" value="{{ $one_info->title }}">
                                    <h5 id="title{{ $one_info->id }}" class="modal-title">{{ $one_info->title }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                  </div>
                                  <div class="modal-body" style="height:auto">
                                    <input type="hidden" name="old_content" value="{{ $one_info->comment }}"></input>
                                    <p id="content{{ $one_info->id }}" style="text-align:left">{{ $one_info->comment }}</p>
                                  </div>
                                  <div class="modal-body">
                                    <input type="hidden" name="info_id" value="{{ $one_info->id }}">
                                    <input type="submit" class="btn btn-primary" value="更新" style="float:right;margin-top:15px;margin-left:20px">
                                  </form>
                                  <button type="button" id="amend{{ $one_info->id }}" class="btn btn-primary" style="float:right;margin-top:15px">修正</button>
                                  <script>
                                   $(function(){
                                     $('#amend{{ $one_info->id }}').click(function(){
                                       $('#title{{ $one_info->id }}').html('<textarea id="title{{ $one_info->id }}" name="new_title" class="form-control" rows="1">' + $('#title{{ $one_info->id }}').text() +'</textarea>');
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
                                     $('#close{{ $one_info->id }}').click(function(){
                                       $('#title{{ $one_info->id }}').html('<h4 id="title{{ $one_info->id }}" class="modal-title">' + $('#title{{ $one_info->id }}').text() + '</h4>');
                                       $('#content{{ $one_info->id }}').html('<span id="content{{ $one_info->id }}" style="float:left">' + $('#content{{ $one_info->id }}').text() +'</span>');
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
                      <td class="list-group-item inline inline_second">{{$one_info->created_at}}</td>
                     </tr>
                     @endforeach
                     <tr>
                      <td class="list-group-item" style="text-align:center">
                        <a href="{{ route('get_create_notice') }}"><button type="button" class="btn btn-primary">戻る</button></a>
                      </td>
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')
@section('title','通知関連')

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
                        <tr>
                          <td class="td">
                            <!-- メインモーダル -->
                            <a href="#myModal{{ $one_info->id }}" data-toggle="modal" data-target="#myModal{{ $one_info->id }}">
                              {{ $one_info->title }}
                            </a>
                            <div div class="modal fade" id="myModal{{ $one_info->id }}">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{ $one_info->title }}</h4>
                                      <button id="subClose{{ $one_info->id }}" type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                      <div style="text-align:left">{!! nl2br($one_info->comment) !!}</div>
                                    </div>
                                    <div class="modal-body">
                                      @if(!$one_info->show_date->lt(\Carbon\Carbon::today()))
                                        <button type="button" id="amend{{ $one_info->id }}" class="btn btn-primary" style="float:right;margin-top:15px" data-toggle="modal" data-target="#subModal{{ $one_info->id }}">修正</button>
                                      @endif
                                  </div>
                                  <div class="modal-footer">
                                    <div class="mr-auto">トータル&nbsp:
                                        <!-- インナーモーダルの表示リンク -->
                                        <a href="" data-toggle="modal" data-target="#inner0Modal{{ $one_info->id }}">
                                            {{ count($one_info->get_users()) }}
                                        </a>人
                                    </div>
                                    <div class="mr-auto">既読&nbsp:
                                        <!-- インナーモーダルの表示リンク -->
                                        <a href="" data-toggle="modal" data-target="#inner1Modal{{ $one_info->id }}">
                                            {{ count($one_info->get_read_users()) }}/{{ count($one_info->get_users()) }}
                                        </a>人
                                    </div>
                                    <div class="mr-auto">未読&nbsp:
                                        <!-- インナーモーダルの表示リンク -->
                                        <a href="" data-toggle="modal" data-target="#inner2Modal{{ $one_info->id }}">
                                            {{ count($one_info->get_unread_users()) }}/{{ count($one_info->get_users()) }}
                                        </a>人
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- インナーモーダル -->
                            <div class="modal fade" id="inner0Modal{{ $one_info->id }}">
                                @component('sub_view.inner_modal',['title' => 'トータル','infos' => $one_info->get_users()])
                                @endcomponent
                            </div>
                            <div class="modal fade" id="inner1Modal{{ $one_info->id }}">
                                @component('sub_view.inner_modal',['title' => '既読','infos' => $one_info->get_read_users()])
                                @endcomponent
                            </div>
                            <div class="modal fade" id="inner2Modal{{ $one_info->id }}">
                                @component('sub_view.inner_modal',['title' => '未読','infos' => $one_info->get_unread_users()])
                                @endcomponent
                            </div>
                            <!-- ここまで -->
                            <!-- サブモーダル -->
                            <div div class="modal fade" id="subModal{{ $one_info->id }}">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('post_updated_info') }}" method="post">
                                      @csrf
                                    <div class="modal-header">
                                      <input type="text" class="form-control" name="title" value="{{ $one_info->title }}">
                                      <input type="hidden" name="info_id" value="{{ $one_info->id }}">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body" style="height:auto">
                                      <textarea name="content" class="form-control">{{ $one_info->comment }}</textarea>
                                    </div>
                                    <div class="modal-body">
                                      <input type="submit" class="btn btn-primary" value="更新" style="float:right;margin-top:15px;margin-left:20px">
                                    </form>
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
                        <td class="td">{{ $one_info->show_date->format('Y-m-d') }}</td>
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

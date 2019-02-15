
<div class="modal-dialog" role="document">
  <div class="modal-content">
      <form action="{{ route('post_updated_info') }}" method="post">
        @csrf
      <div class="modal-header">
        <textarea  class="form-control" name="title">{!! nl2br($one_info->title) !!}</textarea>
        <input type="hidden" name="info_id" value="{{ $one_info->id }}">
        <button  type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body" style="height:auto">
        <textarea  name="comment" class="form-control">{{ $one_info->comment }}</textarea>
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

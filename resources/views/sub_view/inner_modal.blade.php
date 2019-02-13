<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">{{ $title }}</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    <div class="modal-body">
      @foreach($infos as $info)
        <li class="list-group-item">
          {{ $info->user->name }}@if($info->user->admin_flg)（管理員）@endif
        </li>
      @endforeach
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
    </div>
  </div>
</div>

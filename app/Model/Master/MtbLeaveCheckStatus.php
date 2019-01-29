<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class MtbLeaveCheckStatus extends Model
{
  public function users()
  {
    return $this->hasMany('App\Model\Master\MtbLeaveCheckStatus', 'mtb_leave_check_status_id');
  }
}

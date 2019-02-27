<?php

namespace App;

use App\Model\AttendanceRecord;
use App\Model\Users_of_information;
use App\Model\Master\MtbLeaveCheckStatus;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    protected $table ='users';
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','telephone_number',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function EmailToken()
    {
        return $this->hasOne('App\EmailToken');
    }
    public function users_of_informations()
    {
        return $this->hasMany('App\Model\Users_of_information','user_id');
    }

    public function infos()
    {
        return $this->belongsToMany("App\Model\Information", "users_of_informations", "user_id", "information_id");
    }
    public function attendance_records()
    {
        return $this->hasMany('App\Model\AttendanceRecord','user_id');
    }

    public function get_recent_attendance_records($days = 7, $thisday = null) {

        $result = [];



        for($i = ($days - 1); $i >= 0; $i--) {
            if (!$thisday) {
              $one_day = Today()->subDays($i);
            } else {
              $basi_day = clone $thisday;
              $one_day = $basi_day->subDays($i);
            }


            $attendance_record = AttendanceRecord::query()->where("attendance_date", $one_day)->where("user_id", $this->id)->first();
            if(!$attendance_record) {
                $result[$one_day->format("Y年m月d日")] = array(
                    "status" => "no attendance"
                );
            } else {
                $result[$one_day->format("Y年m月d日")] = array(
                    "status" => "attendance",
                    "leave_status" => ($attendance_record->leave_start_time ? true : false),
                    "start_time" => $attendance_record->start_time,
                    "end_time" => $attendance_record->end_time,
                    "reason" => $attendance_record->reason,
                    "leave_start_time" => $attendance_record->leave_start_time,
                    "leave_end_time" => $attendance_record->leave_end_time,
                    "leave_reason" => $attendance_record->leave_reason,
                    "mtb_leave_check_status" => $attendance_record->mtb_leave_check_status ? $attendance_record->mtb_leave_check_status->value : "",
                    "leave_applicate_time" => $attendance_record->leave_applicate_time,
                    "leave_check_time" => $attendance_record->leave_check_time
                );
            }

        }

        return $result;

    }

    public function get_all_infos()
    {

        $result = array();

        foreach ($this->infos as $info) {
            if(!$info->show_date->isFuture()) {
                $result[] = $info;
            }
        }

        usort($result, function($a, $b) {
            if ($a->show_date == $b->show_date) {

                if($a->created_at == $b->created_at) {
                    return 0;
                }
                return ($a->created_at < $b->created_at) ? 1 : -1;
            }
            return ($a->show_date < $b->show_date) ? 1 : -1;
        });

        return count($result) > 0 ? $result : false;

    }

    public function get_all_unread_infos() {

        $result = array();
        $all_infos = $this->get_all_infos();
        if($all_infos) {
            foreach ($all_infos as $info) {
                $user_id = $this->id;
                $info_id = $info->id;
                $user_info = Users_of_information::query()->where("user_id", $user_id)->where("information_id", $info_id)->first();
                if($user_info && !$user_info->read_at) {
                    $result[] = $info;
                }
            }
        }

        usort($result, function($a, $b) {
            if ($a->show_date == $b->show_date) {

                if($a->created_at == $b->created_at) {
                    return 0;
                }
                return ($a->created_at < $b->created_at) ? 1 : -1;
            }
            return ($a->show_date < $b->show_date) ? 1 : -1;
        });

        return count($result) > 0 ? $result : false;
    }

    public function check()
    {
        return $this->hasMany("App\Model\AttendanceRecord", "user_id");
    }

    public function get_late_times()
    {
      $start_of_month = Carbon::today()->startOfMonth();
      $end_of_month = Carbon::today()->endOfMonth();
      $late_times = count($this->attendance_records()
                               ->where('attendance_date','>=',new Carbon($start_of_month))
                               ->where('attendance_date','<=',new Carbon($end_of_month))
                               ->whereNotNull('reason')
                               ->get());
      return $late_times;
    }

    public function get_leave_times($month)
    {
      $start_of_month = Carbon::today()->addMonth($month)->startOfMonth();
      $end_of_month = Carbon::today()->addMonth($month)->endOfMonth();
      $month_leave_times = count($this->attendance_records()
                                             ->where('attendance_date','>=',$start_of_month)
                                             ->where('attendance_date','<=',$end_of_month)
                                             ->where('mtb_leave_check_status_id',MtbLeaveCheckStatus::APPROVAL)
                                             ->get());
      return $month_leave_times;

    }

    public function get_recent_days($days,$format)
    {
      $dayarr = array();
      for($i = $days-1; $i >= 0; $i--){
         $dayarr[$days-1-$i] = Carbon::today()->subDay($i)->format($format);
      }
      return $dayarr;
    }

    public function get_start_time_of_days($days)
    {
      $start_time = array();
      foreach($this->get_recent_days($days,'Y-m-d') as $day){
        $temp = $this->attendance_records()->where('attendance_date',$day)->first();
        if(!$temp) {
            $start_time[] = 0;
        } else {
            $hoge = new Carbon($temp->start_time);
            $temp_hour = intval($hoge->format('H'));
            $temp_minute = intval($hoge->format('i'))/60;
            $temp_start_time = $temp_hour + $temp_minute;
            $start_time[] = $temp_start_time;
        }
      }
      return $start_time;
    }
    public function get_end_time_of_days($days)
    {
      $end_time = array();
      foreach($this->get_recent_days($days,'Y-m-d') as $day){
        $temp = $this->attendance_records()->where('attendance_date',$day)->first();
        if(!$temp) {
            $end_time[] = 0;
        } else {
          $hoge = new Carbon($temp->end_time);
          $temp_hour = intval($hoge->format('H'));
          $temp_minute = intval($hoge->format('i'))/60;
          $temp_end_time = $temp_hour + $temp_minute;
          $end_time[] = $temp_end_time;
        }
      }
      return $end_time;
    }
}

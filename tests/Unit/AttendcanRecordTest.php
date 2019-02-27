<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\AttendanceRecord;
use App\User;
use Carbon\Carbon;

class AttendcanRecordTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCheckLeaveTime()
    {
        $user = User::find(1);

        $result = AttendanceRecord::check_leave_time($user, $attendance_date = Today(), $leave_start_at = '8:00', $leave_end_at = '10:00');

        $this->assertTrue($result);
    }
}

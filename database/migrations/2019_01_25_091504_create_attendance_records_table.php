<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('attendace_date');
            $table->text('start_time')->nullable();
            $table->text('end_time')->nullable();
            $table->text('leave_start_time')->nullable();
            $table->text('leave_end_time')->nullable();
            $table->text('leave_reason')->nullable();
            $table->unsignedInteger('mtb_leave_check_status_id')->nullable();
            $table->foreign('mtb_leave_check_status_id')->references('id')->on('mtb_leave_check_statuses');

            $table->dateTime('leave_applicate_time')->nullable();
            $table->dateTime('leave_check_time')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_records');
    }
}

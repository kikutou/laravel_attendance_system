<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtbLeaveCheckStatusesTable extends Migration
{
    private $master_table_names = [
        'mtb_leave_check_statuses' =>array(
            array(
                "id" => 1,
                "value" => "承認待ち",
                "rank" => 1
            ),
            array(
                "id" => 2,
                "value" => "承認済",
                "rank" => 2
            ),
            array(
                "id" => 3,
                "value" => "断り",
                "rank" => 3
            )
        )
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->master_table_names as $tbl_name => $records) {

            Schema::create($tbl_name, function (Blueprint $table) {
                $table->increments('id');
                $table->text('value');
                $table->integer('rank');
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            });

            DB::table($tbl_name)->insert($records); // Query Builderでの方法
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->master_table_names as $tbl_name => $table_contents) {
            Schema::dropIfExists($tbl_name);
        }
    }
}

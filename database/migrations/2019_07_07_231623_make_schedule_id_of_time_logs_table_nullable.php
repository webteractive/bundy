<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeScheduleIdOfTimeLogsTableNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_logs', function (Blueprint $table) {
            $table->bigInteger('schedule_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_logs', function (Blueprint $table) {
            $table->bigInteger('schedule_id')->change();
        });
    }
}

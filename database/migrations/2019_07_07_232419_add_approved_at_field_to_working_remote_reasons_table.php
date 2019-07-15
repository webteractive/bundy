<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedAtFieldToWorkingRemoteReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('working_remote_reasons', function (Blueprint $table) {
            $table->dateTime('approved_at')->nullable()->after('worked_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('working_remote_reasons', function (Blueprint $table) {
            $table->dropColumn('approved_at');
        });
    }
}

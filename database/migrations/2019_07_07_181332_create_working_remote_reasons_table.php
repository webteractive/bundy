<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingRemoteReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_remote_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('reason');
            $table->string('ip');
            $table->bigInteger('user_id');
            $table->date('worked_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_remote_reasons');
    }
}

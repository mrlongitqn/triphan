<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionMarksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_marks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('session');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('desc');
            $table->string('course_ids');
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
        Schema::drop('session_marks');
    }
}

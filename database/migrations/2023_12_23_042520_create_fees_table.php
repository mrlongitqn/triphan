<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('course_student_id');
            $table->integer('course_id');
            $table->integer('student_id');
            $table->integer('year');
            $table->integer('month');
            $table->integer('fee');
            $table->integer('amount');
            $table->integer('remain');
            $table->integer('status');
            $table->integer('refund');
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
        Schema::drop('fees');
    }
}

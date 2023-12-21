<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->date('dob');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('level_id');
            $table->string('school')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_phone1')->nullable();
            $table->string('parent_phone2')->nullable();
            $table->string('parent_mail')->nullable();
            $table->string('note')->nullable();
            $table->integer('user_id');
            $table->integer('status');
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
        Schema::drop('students');
    }
}

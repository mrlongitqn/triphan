<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('origin');
            $table->integer('amount');
            $table->integer('remain');
            $table->integer('month');
            $table->integer('year');
            $table->string('note');
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
        Schema::drop('fee_details');
    }
}

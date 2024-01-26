<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn('score','session_id');
            $table->decimal('score1',2,2,true)->nullable();
            $table->decimal('score2',2,2,true)->nullable();
            $table->decimal('score3',2,2,true)->nullable();
            $table->decimal('score4',2,2,true)->nullable();
            $table->decimal('score5',2,2,true)->nullable();
            $table->decimal('score6',2,2,true)->nullable();
            $table->decimal('score7',2,2,true)->nullable();
            $table->decimal('score8',2,2,true)->nullable();
            $table->decimal('score9',2,2,true)->nullable();
            $table->decimal('score10',2,2,true)->nullable();
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
        Schema::table('marks', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fees', function (Blueprint $table) {
            //
            $table->dropColumn('year');
            $table->dropColumn('month');
            $table->dropColumn('fee');
            $table->dropColumn('remain');
            $table->integer('discount');
            $table->string('note');
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
        Schema::table('fees', function (Blueprint $table) {
            //
        });
    }
}

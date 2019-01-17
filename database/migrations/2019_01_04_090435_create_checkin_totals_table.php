<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_totals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('child_id');
            // $table->float('am_total_hours')->default(0);
            // $table->float('total_hours')->default(0);
            // $table->float('total_amount')->default(0);
            $table->integer('am_total_hours')->default(0);
            $table->integer('total_hours')->default(0);
            $table->integer('total_amount')->default(0);
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
        Schema::dropIfExists('checkin_totals');
    }
}

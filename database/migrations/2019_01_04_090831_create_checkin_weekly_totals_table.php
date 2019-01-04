<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinWeeklyTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_weekly_totals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('checkin_totals_id');
            $table->unsignedInteger('child_id');
            $table->integer('total_week_time')->default(0);
            $table->integer('week_total')->default(0);
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
        Schema::dropIfExists('checkin_weekly_totals');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('child_id');
            $table->boolean('am_checkin')->default(0);
            $table->boolean('pm_checkin')->default(0);
            $table->text('am_sig')->nullable();
            $table->text('pm_sig')->nullable();
            // Add late fees here??
            $table->integer('late_fee')->default(0)->max(3);
            $table->dateTime('am_checkin_time')->nullable();
            $table->dateTime('pm_checkin_time')->nullable();
            $table->dateTime('pm_checkout_time')->nullable();
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
        Schema::dropIfExists('checkins');
    }
}

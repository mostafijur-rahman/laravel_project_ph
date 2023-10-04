<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripSettingAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_area_trip', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('setting_area_id')->index();
            $table->unsignedBigInteger('trip_id')->index();
            $table->enum('point', ['load','unload']);
        
            $table->foreign('setting_area_id')->references('id')->on('setting_areas')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_setting_area');
    }
}
